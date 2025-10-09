@extends('layouts.app')

@section('title', 'Installeur - Bienvenue')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Bienvenue dans l'installeur Laravel
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Ce processus va vous guider à travers l'installation de votre application.
                </p>
            </div>

            <!-- Barre de progression -->
            <div class="mt-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">✓</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Vérification de l'environnement</p>
                            <p class="text-sm text-gray-500">Configuration système vérifiée</p>
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
                            <p class="text-sm text-gray-500">Configuration de la base de données et administrateur</p>
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
                            <p class="text-sm text-gray-500">Migration et initialisation de la base de données</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('install.configure') }}" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Commencer la configuration
                </a>
            </div>

            <!-- Information système -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Vérification de l'environnement :</h3>
                <div class="space-y-2">
                    @foreach($checks as $key => $check)
                        <div class="flex justify-between items-center py-1 border-b border-gray-200">
                            <span class="text-sm text-gray-600">{{ $check['name'] }}</span>
                            <span class="text-sm {{ $check['status'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $check['status'] ? '✓' : '✗' }} {{ $check['message'] }}
                            </span>
                        </div>
                    @endforeach
                </div>

                @php
                    $allChecksPassed = collect($checks)->every('status');
                @endphp

                @if(!$allChecksPassed)
                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                        <div class="flex">
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Vérifications échouées
                                </h3>
                                <p class="text-sm text-red-700 mt-1">
                                    Certains prérequis ne sont pas remplis. Veuillez corriger les problèmes avant de continuer.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-8 text-center">
                @if($allChecksPassed)
                    <a href="{{ route('install.configure') }}" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Commencer la configuration
                    </a>
                @else
                    <button disabled class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-gray-400 bg-gray-200 cursor-not-allowed">
                        Corriger les erreurs avant de continuer
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
