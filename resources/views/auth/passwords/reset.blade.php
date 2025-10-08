<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réinitialiser le mot de passe</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-background text-white min-h-screen flex items-center justify-center overflow-hidden">
    <div class="bg-gray-900 p-6 sm:p-8 rounded-lg shadow-lg max-w-md w-full mx-2">
        <h1 class="text-2xl font-semibold text-primary mb-6 text-center">Définir un nouveau mot de passe</h1>
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            <div>
                <label for="password" class="block mb-1 text-sm">Nouveau mot de passe</label>
                <input id="password" type="password" name="password" required
                       class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400 text-white" />
            </div>
            <div>
                <label for="password_confirmation" class="block mb-1 text-sm">Confirmer le mot de passe</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400 text-white" />
            </div>
            <button type="submit" class="w-full py-2 bg-primary text-black font-semibold rounded hover:bg-opacity-90 transition">Réinitialiser le mot de passe</button>
        </form>
    </div>
</body>
</html>