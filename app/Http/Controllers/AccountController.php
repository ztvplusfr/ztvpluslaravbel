<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        return view('account', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if ($request->field === 'email') {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $user->id
            ]);

            $user->email = $request->email;
            $user->save();
            return back()->with('success', 'Email mis à jour avec succès.');
        }

        if ($request->field === 'password') {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|confirmed|min:8',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }

            $user->password = Hash::make($request->password);
            $user->save();
            return back()->with('success', 'Mot de passe changé avec succès.');
        }

        // Profile update (name, country, max_streams, avatar)
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'max_streams' => 'nullable|integer|min:1|max:10',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->name = $request->name;
        $user->country = $request->country;
        $user->max_streams = $request->max_streams;

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }

            // Ensure directory exists
            Storage::makeDirectory('avatars'); // In public disk

            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs('avatars', $filename, 'public');
            $user->avatar = 'avatars/' . $filename;
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function destroy(): RedirectResponse
    {
        $user = auth()->user();

        // Delete avatar if exists
        if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
            Storage::delete('public/' . $user->avatar);
        }

        // Logout and delete user
        auth()->logout();
        $user->delete();

        return redirect('/')->with('success', 'Votre compte a été supprimé définitivement.');
    }
}
