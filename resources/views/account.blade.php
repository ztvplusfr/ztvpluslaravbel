<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ZTV Plus - Mon Compte</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text min-h-screen">
    <x-navbar :currentRoute="request()->route()->getName()" />

    <div class="pt-24 px-4 md:px-6 max-w-4xl mx-auto">
        @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-500 text-white px-4 py-3 rounded mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1 class="text-3xl font-bold text-white mb-8">Paramètres du compte</h1>

        <!-- Profile Section -->
        <section class="bg-gray-800 p-6 rounded-lg mb-6">
            <h2 class="text-xl font-semibold text-white mb-4">Gestion du profil</h2>
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4 mb-6">
                <div class="flex justify-center md:justify-start">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full">
                    @else
                        <div class="w-20 h-20 bg-gray-600 rounded-full flex items-center justify-center">
                            <svg class="h-8 w-8 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-white mb-1">Nom</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-gray-700 text-white px-3 py-2 rounded">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-white mb-1">Pays</label>
                                <select name="country" class="w-full bg-gray-700 text-white px-3 py-2 rounded">
                                    <option value="">Sélectionner un pays</option>
                                    <option value="FR" {{ $user->country === 'FR' ? 'selected' : '' }}>France</option>
                                    <option value="BE" {{ $user->country === 'BE' ? 'selected' : '' }}>Belgique</option>
                                    <option value="RE" {{ $user->country === 'RE' ? 'selected' : '' }}>Réunion</option>
                                    <option value="YT" {{ $user->country === 'YT' ? 'selected' : '' }}>Mayotte</option>
                                    <option value="US" {{ $user->country === 'US' ? 'selected' : '' }}>États-Unis</option>
                                    <option value="CA" {{ $user->country === 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="GB" {{ $user->country === 'GB' ? 'selected' : '' }}>Royaume-Uni</option>
                                    <option value="DE" {{ $user->country === 'DE' ? 'selected' : '' }}>Allemagne</option>
                                    <option value="JP" {{ $user->country === 'JP' ? 'selected' : '' }}>Japon</option>
                                    <option value="AUTRE" {{ $user->country && !in_array($user->country, ['FR', 'BE', 'RE', 'YT', 'US', 'CA', 'GB', 'DE', 'JP']) ? 'selected' : '' }}>Autre</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-white mb-1">Nombre maximum de streams</label>
                                <select name="max_streams" class="w-full bg-gray-700 text-white px-3 py-2 rounded">
                                    <option value="">Sélectionner</option>
                                    @for($i = 1; $i <= 2; $i++)
                                        <option value="{{ $i }}" {{ $user->max_streams == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-white mb-1">Avatar</label>
                            <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-gray-300 bg-gray-700 px-3 py-2 rounded">
                        </div>
                        <button type="submit" class="bg-primary text-background px-4 py-2 rounded hover:bg-opacity-80 transition">
                            Sauvegarder les modifications
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Account Settings -->
        <section class="bg-gray-800 p-6 rounded-lg mb-6">
            <h2 class="text-xl font-semibold text-white mb-4">Paramètres du compte</h2>

            <div class="space-y-4">
                <!-- Email -->
                <div>
                    <label class="block text-white mb-1">Email</label>
                    <form action="{{ route('account.update') }}" method="POST" class="flex items-center">
                        @csrf
                        <input type="hidden" name="field" value="email">
                        <input type="email" name="email" value="{{ $user->email }}" class="flex-1 bg-gray-700 text-white px-3 py-2 rounded-l">
                        <button type="submit" class="bg-primary text-background px-4 py-2 rounded-r hover:bg-opacity-80 transition">
                            Modifier
                        </button>
                    </form>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-white mb-1">Mot de passe</label>
                    <form action="{{ route('account.update') }}" method="POST" class="space-y-2">
                        @csrf
                        <input type="hidden" name="field" value="password">
                        <input type="password" name="current_password" placeholder="Mot de passe actuel" class="w-full bg-gray-700 text-white px-3 py-2 rounded" required>
                        <input type="password" name="password" placeholder="Nouveau mot de passe" class="w-full bg-gray-700 text-white px-3 py-2 rounded" required minlength="8">
                        <input type="password" name="password_confirmation" placeholder="Confirmer le nouveau mot de passe" class="w-full bg-gray-700 text-white px-3 py-2 rounded" required>
                        <button type="submit" class="bg-primary text-background px-4 py-2 rounded hover:bg-opacity-80 transition">
                            Changer le mot de passe
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Delete Account -->
        <section class="bg-red-900 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-white mb-4">Supprimer le compte</h2>
            <p class="text-gray-300 mb-4">Cette action est irréversible et supprimera définitivement votre compte et toutes les données associées.</p>
            <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition" onclick="confirmDelete()">
                Supprimer mon compte
            </button>
        </section>
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-gray-800 p-6 rounded-lg max-w-md w-full mx-4">
            <h3 class="text-white text-lg font-bold mb-4">Confirmer la suppression</h3>
            <p class="text-gray-300 mb-4">Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est définitive.</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-700 transition">
                    Annuler
                </button>
                <form action="{{ route('account.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 rounded hover:bg-red-700 transition">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</body>
</html>
