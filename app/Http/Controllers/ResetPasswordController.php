<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request)
    {
        // Vérifie que le token et l'email sont présents
        if (!$request->has('token') || !$request->has('email')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Le lien de réinitialisation est invalide.']);
        }

        // Vérifie que le token existe dans la base de données
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenData) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Ce lien de réinitialisation est invalide ou a expiré.']);
        }

        // Vérifie que le token correspond (Laravel stocke le token hashé)
        if (!Hash::check($request->token, $tokenData->token)) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Ce lien de réinitialisation est invalide.']);
        }

        // Vérifie que le token n'est pas expiré en utilisant la colonne expires_at
        if (now()->isAfter($tokenData->expires_at)) {
            // Supprime le token expiré
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Ce lien de réinitialisation a expiré (10 minutes). Veuillez en demander un nouveau.']);
        }

        // Si tout est OK, affiche le formulaire
        return view('auth.passwords.reset', ['token' => $request->token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Vérifie le token avant de réinitialiser
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenData || !Hash::check($request->token, $tokenData->token)) {
            return back()->withErrors(['email' => 'Ce lien de réinitialisation est invalide.']);
        }

        if (now()->isAfter($tokenData->expires_at)) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Ce lien a expiré (10 minutes).']);
        }

        // Trouve l'utilisateur et réinitialise le mot de passe
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Utilisateur introuvable.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Supprime le token après utilisation
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Envoie un email de confirmation
        $gmail = new GmailApiController();
        $gmail->sendPasswordChangedEmail($user->email, $user->name);

        return redirect()->route('login')->with('status', 'Votre mot de passe a été réinitialisé avec succès !');
    }
}