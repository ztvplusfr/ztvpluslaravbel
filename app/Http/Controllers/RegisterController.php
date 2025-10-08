<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */
    public function show()
    {
        return view('register');
    }

    /**
     * Traite l'inscription de l'utilisateur.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'avatar' => 'nullable|image|max:2048',
            'language' => 'required|string|in:fr,en',
            'country' => 'required|string|in:FR,BE,RE,YT',
            'max_streams' => 'required|integer|min:1|max:2',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        } else {
            $data['avatar'] = null;
        }

        $data['password'] = Hash::make($data['password']);
        // Assure que max_streams est bien un entier (1 ou 2)
        $data['max_streams'] = intval($data['max_streams']);

        User::create($data);

        return redirect()->route('login')->with('success', 'Inscription réussie, connectez-vous.');
    }
}
