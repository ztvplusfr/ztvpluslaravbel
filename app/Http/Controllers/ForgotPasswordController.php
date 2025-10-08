<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->input('email');
        
        // Vérifie l'utilisateur existant
        $user = \App\Models\User::where('email', $email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Aucun utilisateur trouvé pour cette adresse']);
        }
        
        // Supprime les anciens tokens pour cet email
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        
        // Génère un nouveau token
        $token = Str::random(64);
        
        // Stocke le token avec expiration à 10 minutes
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => bcrypt($token),
            'created_at' => now(),
            'expires_at' => now()->addMinutes(10)
        ]);
        
        // Construit le lien de réinitialisation
        $resetLink = url("/reset-password?token={$token}&email=" . urlencode($email));
        
        // Envoie l'email via Gmail API
        $gmail = new GmailApiController();
        $result = $gmail->sendPasswordResetEmail($email, $resetLink);
        
        if (strpos($result, 'Erreur') === 0) {
            return back()->withErrors(['email' => $result]);
        }
        
        return back()->with('status', 'Lien de réinitialisation envoyé via Gmail API ! Le lien expire dans 10 minutes.');
    }
}
