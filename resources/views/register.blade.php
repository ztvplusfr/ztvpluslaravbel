<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-background text-white min-h-screen flex items-center justify-center">
    <div x-data="{
        step: 1,
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        avatar: null,
        language: 'fr',
        country: 'FR',
        max_streams: '1'
    }" class="bg-gray-900 p-6 sm:p-8 rounded-lg shadow-lg max-w-md w-full mx-2">
        <div class="flex justify-center mb-6">
            <img class="h-20 w-auto" src="{{ asset('brand/logo.png') }}" alt="Logo" />
        </div>
        <h1 class="text-2xl font-semibold text-primary mb-6 text-center">Inscription</h1>
        <!-- Barre de progression -->
        <div class="flex items-center mb-6 px-4">
            <div class="flex flex-col items-center">
                <div :class="step === 1 ? 'bg-primary' : 'bg-gray-600'" class="w-8 h-8 rounded-full flex items-center justify-center text-white">1</div>
                <span class="mt-2 text-sm">Étape 1</span>
            </div>
            <div :class="step > 1 ? 'border-primary' : 'border-gray-600'" class="flex-1 border-t-2 mx-4"></div>
            <div class="flex flex-col items-center">
                <div :class="step === 2 ? 'bg-primary' : 'bg-gray-600'" class="w-8 h-8 rounded-full flex items-center justify-center text-white">2</div>
                <span class="mt-2 text-sm">Étape 2</span>
            </div>
        </div>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <!-- Étape 1 -->
            <div x-show="step === 1">
                <div>
                    <label for="name" class="block mb-1 text-sm">Nom</label>
                    <input id="name" x-model="name" type="text" name="name" required autofocus
                           class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400 text-white" />
                </div>
                <div>
                    <label for="email" class="block mb-1 text-sm">Email</label>
                    <input id="email" x-model="email" type="email" name="email" required
                           class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400 text-white" />
                </div>
                <div>
                    <label for="password" class="block mb-1 text-sm">Mot de passe</label>
                    <input id="password" x-model="password" type="password" name="password" required
                           class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400 text-white" />
                </div>
                <div>
                    <label for="password_confirmation" class="block mb-1 text-sm">Confirmer le mot de passe</label>
                    <input id="password_confirmation" x-model="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400 text-white" />
                </div>
            </div>
            <!-- Étape 2 -->
            <div x-show="step === 2" x-cloak>
                <!-- Champ avatar -->
                <div>
                    <label for="avatar" class="block mb-1 text-sm">Photo de profil</label>
                    <input id="avatar" type="file" name="avatar"
                           class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400 text-white" />
                </div>
                <!-- Champ langue -->
                <div>
                    <label for="language" class="block mb-1 text-sm">Langue</label>
                    <select id="language" name="language" required
                           class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary text-white">
                        <option value="fr">Français</option>
                        <option value="en">Anglais</option>
                    </select>
                </div>
                <!-- Champ pays/région -->
                <div x-show="step === 2" x-cloak>
                    <label for="country" class="block mb-1 text-sm">Pays / Région</label>
                    <select id="country" name="country" required
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary text-white">
                        <option value="FR">France (FR)</option>
                        <option value="BE">Belgique (BE)</option>
                        <option value="RE">La Réunion (RE)</option>
                        <option value="YT">Mayotte (YT)</option>
                    </select>
                </div>
                <!-- Champ écrans simultanés -->
                <div>
                    <label for="max_streams" class="block mb-1 text-sm">Écrans simultanés</label>
                    <select id="max_streams" x-model="max_streams" name="max_streams" required
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:ring-2 focus:ring-primary text-white">
                        <option value="1">1 écran</option>
                        <option value="2">2 écrans</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-between mt-4">
                <button type="button" x-show="step === 2" @click="step = 1" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-opacity-90 transition">Précédent</button>
                <button type="button"
                        x-show="step === 1"
                        :disabled="!(name && email && password && password_confirmation && password === password_confirmation)"
                        @click="step = 2"
                        :class="{ 'opacity-50 cursor-not-allowed': !(name && email && password && password_confirmation && password === password_confirmation) }"
                        class="ml-auto px-4 py-2 bg-primary text-black font-semibold rounded hover:bg-opacity-90 transition">
                    Suivant
                </button>
                <button type="submit" x-show="step === 2" class="ml-auto px-4 py-2 bg-primary text-black font-semibold rounded hover:bg-opacity-90 transition">Valider</button>
            </div>
        </form>
        <p class="mt-4 text-center">
            Déjà un compte ? <a href="{{ route('login') }}" class="text-primary underline hover:text-primary/80">Se connecter</a>
        </p>
    </div>

    <!-- Alpine.js pour le multi-step -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
@if(session('success'))
    <div x-data class="fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow-lg">
        {{ session('success') }}
    </div>
@endif
</html>
