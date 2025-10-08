<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-background text-white min-h-screen flex items-center justify-center overflow-hidden">
    <div class="bg-gray-900 p-6 sm:p-8 rounded-lg shadow-lg max-w-md w-full mx-2">
        <div class="flex justify-center mb-6">
            <img class="h-20 w-auto" src="{{ asset('brand/logo.png') }}" alt="Logo" />
        </div>
        <h1 class="text-2xl font-semibold text-primary mb-6 text-center">Se connecter</h1>
        @if ($errors->any())
            <div class="mb-4 text-red-500 text-center">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block mb-1 text-sm">Email</label>
                <input id="email" type="email" name="email" required autofocus
                       class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400 text-white" />
            </div>
            <div>
                <label for="password" class="block mb-1 text-sm">Mot de passe</label>
                <input id="password" type="password" name="password" required
                       class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400 text-white" />
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <input type="checkbox" name="remember" id="remember" class="mr-1" />
                    <label for="remember" class="text-sm">Se souvenir de moi</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">Mot de passe oublié?</a>
            </div>
            <button type="submit" class="w-full py-2 bg-primary text-black font-semibold rounded hover:bg-opacity-90 transition">Connexion</button>
            <p class="mt-4 text-center">
                Pas encore de compte ? <a href="{{ route('register') }}" class="text-primary underline hover:text-primary/80">S'inscrire</a>
            </p>
        </form>
    </div>
</body>
</html>
