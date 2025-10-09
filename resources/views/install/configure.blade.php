@extends('layouts.app')

@section('title', 'Installeur - Configuration')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Configuration de l'application
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Remplissez les informations suivantes pour configurer votre installation.
                </p>
            </div>

            <!-- Barre de progression -->
            <div class="mt-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">✓</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Vérification de l'environnement</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">2</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Configuration</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-500 font-semibold text-sm">3</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400">Installation</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire de configuration -->
            <form method="POST" action="{{ route('install.saveConfig') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Configuration Base de Données -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Configuration de la base de données</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="db_name" class="block text-sm font-medium text-gray-700">
                                Nom de la base de données *
                            </label>
                            <input type="text" name="db_name" id="db_name" value="{{ old('db_name') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                placeholder="nom_de_la_base" required>
                            @error('db_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="db_user" class="block text-sm font-medium text-gray-700">
                                Utilisateur MySQL *
                            </label>
                            <input type="text" name="db_user" id="db_user" value="{{ old('db_user', 'root') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                required>
                            @error('db_user')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="db_password" class="block text-sm font-medium text-gray-700">
                                Mot de passe MySQL
                            </label>
                            <input type="password" name="db_password" id="db_password" value="{{ old('db_password') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                placeholder="Laissez vide si pas de mot de passe">
                            @error('db_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @error('db_connection')
                        <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Erreur de connexion à la base de données
                                    </h3>
                                    <p class="text-sm text-red-700 mt-1">{{ $message }}</p>
                                </div>
                            </div>
                        </div>
                    @enderror
                </div>

                <!-- Configuration de l'Application -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Configuration de l'application</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700">
                                Nom du site *
                            </label>
                            <input type="text" name="site_name" id="site_name" value="{{ old('site_name', 'ZTV Plus') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                required>
                            @error('site_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Configuration Administrateur -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Compte administrateur</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="admin_email" class="block text-sm font-medium text-gray-700">
                                Email administrateur *
                            </label>
                            <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                placeholder="admin@example.com" required>
                            @error('admin_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="admin_password" class="block text-sm font-medium text-gray-700">
                                Mot de passe administrateur *
                            </label>
                            <input type="password" name="admin_password" id="admin_password" value="{{ old('admin_password') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                required minlength="8">
                            @error('admin_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Minimum 8 caractères</p>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex space-x-4">
                    <a href="{{ route('install.welcome') }}"
                        class="flex-1 flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Retour
                    </a>
                    <button type="submit"
                        class="flex-1 flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Continuer vers l'installation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
