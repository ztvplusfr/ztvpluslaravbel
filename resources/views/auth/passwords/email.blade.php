<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mot de passe oublié</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-background text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-900 p-6 sm:p-8 rounded-lg shadow-lg max-w-md w-full mx-2">
        <h1 class="text-2xl font-semibold text-primary mb-6 text-center">Réinitialiser le mot de passe</h1>
        @if (session('status'))
            <div class="mb-4 text-green-500 text-center">
                {{ session('status') }}
            </div>
        @endif
            @if ($errors->has('email'))
                <div class="mb-4 text-red-500 text-center">
                    @if (str_contains($errors->first('email'), 'Aucun utilisateur'))
                        L'adresse e-mail n'est pas associée à un compte. Veuillez réessayer ou créer un nouveau compte.
                    @else
                        {{ $errors->first('email') }}
                    @endif
                </div>
                @endif
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block mb-1 text-sm">Adresse email</label>
                <input id="email" type="email" name="email" required autofocus
                       class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400 text-white" />
            </div>
            <button type="submit" class="w-full py-2 bg-primary text-black font-semibold rounded hover:bg-opacity-90 transition">Envoyer le lien de réinitialisation</button>
        </form>
        <p class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-primary underline hover:text-primary/80">Retour à la connexion</a>
        </p>
    </div>
</body>
</html>
