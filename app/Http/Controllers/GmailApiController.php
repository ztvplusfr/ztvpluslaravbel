<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;

class GmailApiController extends Controller
{
    /**
     * Initialise et retourne un client Google configuré pour Gmail API.
     */
    private function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('ZTVPlus Gmail API');
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setAccessToken(env('GOOGLE_ACCESS_TOKEN'));
        $client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
        $client->setScopes(['https://www.googleapis.com/auth/gmail.send']);

        if ($client->isAccessTokenExpired()) {
            $refreshToken = env('GOOGLE_REFRESH_TOKEN');
            if ($refreshToken) {
                $client->refreshToken($refreshToken);
            } else {
                throw new \Exception("Le token d'accès est expiré et aucun refresh token n'est configuré.");
            }
        }
        return $client;
    }
    public function sendTestEmail()
    {
        $client = new Google_Client();
        $client->setApplicationName('ZTVPlus Gmail API');
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setAccessToken(env('GOOGLE_ACCESS_TOKEN'));
        $client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
        $client->setScopes(['https://www.googleapis.com/auth/gmail.send']);

        if ($client->isAccessTokenExpired()) {
            $refreshToken = env('GOOGLE_REFRESH_TOKEN');
            if ($refreshToken) {
                $client->refreshToken($refreshToken);
                // Optionnel : sauvegarder le nouveau token dans .env ou ailleurs
            } else {
                return 'Le token d\'accès est expiré et aucun refresh token n\'est configuré.';
            }
        }

        $gmail = new Google_Service_Gmail($client);

        $strRawMessage = "From: contact.watchflixre@gmail.com\r\n" .
            "To: enriixk.glss@gmail.com, zflixfr-contact@proton.me, enrikkuuu@proton.me\r\n" .
            "Subject: Test Email Gmail API\r\n\r\n" .
            "Ceci est un test d'envoi d'email via l'API Gmail depuis Laravel.";
        $rawMessage = base64_encode($strRawMessage);
        $message = new Google_Service_Gmail_Message();
        $message->setRaw(strtr($rawMessage, array('+' => '-', '/' => '_')));

        try {
            $gmail->users_messages->send('me', $message);
            return 'Email envoyé via Gmail API !';
        } catch (\Exception $e) {
            return 'Erreur : ' . $e->getMessage();
        }
    }

    /**
     * Envoie un email de réinitialisation de mot de passe via Gmail API.
     *
     * @param string $toEmail
     * @param string $resetLink
     * @return string
     */
    public function sendPasswordResetEmail(string $toEmail, string $resetLink): string
    {
        // Récupère le nom de l'utilisateur
        $user = \App\Models\User::where('email', $toEmail)->first();
        $userName = $user ? $user->name : '';
        
        // Charger et encoder le logo en Base64
        $logoPath = public_path('brand/logo.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoBase64 = 'data:image/png;base64,' . $logoData;

        // Construction du message email avec boundary pour multipart
        $boundary = uniqid('boundary_');
        
        // En-têtes
        $headers = [
            'From: contact.watchflixre@gmail.com',
            'To: ' . $toEmail,
            'Subject: =?UTF-8?B?' . base64_encode(utf8_encode('Reinitialisation du mot de passe de votre compte ZTVPlus')) . '?=',
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit'
        ];

        // Corps HTML
        $htmlBody = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div style="font-family:Arial,sans-serif;background:#18181b;padding:32px;color:#fff;border-radius:8px;max-width:500px;margin:auto;">
        <div style="text-align:center;margin-bottom:24px;">
            <img src="' . $logoBase64 . '" alt="Logo ZTVPlus" style="height:60px;">
        </div>
        <h2 style="color:#7F9CF5;">Bonjour ' . htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') . ',</h2>
        <p>Vous avez demande la reinitialisation de votre mot de passe.</p>
        <p>
            <a href="' . $resetLink . '" style="display:inline-block;padding:12px 24px;background:#7F9CF5;color:#18181b;text-decoration:none;border-radius:4px;font-weight:bold;">
                Reinitialiser mon mot de passe
            </a>
        </p>
        <p style="margin-top:24px;font-size:14px;color:#bbb;">
            Si vous n\'avez pas demande cela, ignorez cet email.
        </p>
        <hr style="border:none;border-top:1px solid #333;margin:24px 0;">
        <p style="font-size:13px;color:#aaa;">
            Cordialement,<br>L\'equipe ZTVPlus
        </p>
    </div>
</body>
</html>';

        // Construire le message brut RFC 2822
        $rawMessageString = implode("\r\n", $headers) . "\r\n\r\n" . $htmlBody;
        
        // Encoder en base64 URL-safe pour Gmail API
        $rawMessage = base64_encode($rawMessageString);
        $rawMessage = strtr($rawMessage, ['+' => '-', '/' => '_']);
        
        $message = new Google_Service_Gmail_Message();
        $message->setRaw($rawMessage);
        
        try {
            $gmail = new Google_Service_Gmail($this->getClient());
            $gmail->users_messages->send('me', $message);
            return 'Lien de réinitialisation envoyé !';
        } catch (\Exception $e) {
            return 'Erreur envoi reset : ' . $e->getMessage();
        }
    }

    /**
     * Envoie un email de confirmation après changement de mot de passe.
     *
     * @param string $toEmail
     * @param string $userName
     * @return string
     */
    public function sendPasswordChangedEmail(string $toEmail, string $userName): string
    {
        // Charger et encoder le logo en Base64
        $logoPath = public_path('brand/logo.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoBase64 = 'data:image/png;base64,' . $logoData;

        // En-têtes
        $headers = [
            'From: contact.watchflixre@gmail.com',
            'To: ' . $toEmail,
            'Subject: =?UTF-8?B?' . base64_encode(utf8_encode('Votre mot de passe a ete modifie')) . '?=',
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit'
        ];

        // Corps HTML
        $htmlBody = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div style="font-family:Arial,sans-serif;background:#18181b;padding:32px;color:#fff;border-radius:8px;max-width:500px;margin:auto;">
        <div style="text-align:center;margin-bottom:24px;">
            <img src="' . $logoBase64 . '" alt="Logo ZTVPlus" style="height:60px;">
        </div>
        <h2 style="color:#7F9CF5;">Bonjour ' . htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') . ',</h2>
        <p>Votre mot de passe a ete modifie avec succes.</p>
        <p style="margin-top:24px;font-size:14px;color:#bbb;">
            Si vous n\'avez pas effectue cette action, veuillez contacter notre support immediatement.
        </p>
        <p style="margin-top:24px;">
            <a href="' . url('/') . '" style="display:inline-block;padding:12px 24px;background:#7F9CF5;color:#18181b;text-decoration:none;border-radius:4px;font-weight:bold;">
                Acceder a ZTVPlus
            </a>
        </p>
        <hr style="border:none;border-top:1px solid #333;margin:24px 0;">
        <p style="font-size:13px;color:#aaa;">
            Cordialement,<br>L\'equipe ZTVPlus
        </p>
    </div>
</body>
</html>';

        // Construire le message brut RFC 2822
        $rawMessageString = implode("\r\n", $headers) . "\r\n\r\n" . $htmlBody;
        
        // Encoder en base64 URL-safe pour Gmail API
        $rawMessage = base64_encode($rawMessageString);
        $rawMessage = strtr($rawMessage, ['+' => '-', '/' => '_']);
        
        $message = new Google_Service_Gmail_Message();
        $message->setRaw($rawMessage);
        
        try {
            $gmail = new Google_Service_Gmail($this->getClient());
            $gmail->users_messages->send('me', $message);
            return 'Email de confirmation envoyé !';
        } catch (\Exception $e) {
            return 'Erreur envoi confirmation : ' . $e->getMessage();
        }
    }
}