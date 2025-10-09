@extends('layouts.app')

@section('title', 'Installeur - Installation')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Installation en cours
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Veuillez patienter pendant l'installation...
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
                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">✓</span>
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
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">3</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Installation</p>
                            <p class="text-sm text-gray-500">Migration et initialisation de la base de données</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire d'installation -->
            <form method="POST" action="{{ route('install.saveInstall') }}" class="mt-8" id="installForm">
                @csrf

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Étapes d'installation :</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center">
                                        <span class="text-white font-semibold text-xs">✓</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">Configuration sauvegardée</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center animate-pulse">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">Génération de la clé d'application</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-500 font-semibold text-xs">○</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Migrations de la base de données</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-500 font-semibold text-xs">○</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Création des données</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-500 font-semibold text-xs">○</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Création du compte administrateur</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-500 font-semibold text-xs">○</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-500">Finalisation</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton d'installation (sera soumis automatiquement) -->
                <div class="mt-8 text-center">
                    <button type="submit" id="installButton"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Lancer l'installation
                    </button>
                </div>
            </form>

            <script>
                // Soumettre automatiquement le formulaire après chargement de la page
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(function() {
                        document.getElementById('installForm').submit();
                    }, 1000); // 1 seconde de délai
                });
            </script>
        </div>
    </div>
</div>
@endsection
