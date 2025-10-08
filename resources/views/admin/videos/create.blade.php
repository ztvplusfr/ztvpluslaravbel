@extends('layouts.admin')

@section('title', 'Ajouter une Vidéo')

@section('content')
<h1 class="text-3xl font-bold text-primary mb-6">Ajouter une Vidéo pour "{{ $movie->title }}"</h1>
<p class="mb-4">Bienvenue, {{ Auth::user()->name }} ! Remplissez le formulaire ci-dessous.</p>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.movies.videos.store', ['movie' => $movie->id]) }}" method="POST" class="bg-background p-6 rounded-lg border border-primary w-full">
    @csrf

    <div class="mb-4">
        <label for="embed_link" class="block text-sm font-medium text-gray-200">Lien d'intégration</label>
        <input type="url" name="embed_link" id="embed_link" class="mt-1 block w-full bg-background border border-primary rounded-md text-white px-3 py-2 shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="language" class="block text-sm font-medium text-gray-200">Langue</label>
            <input type="text" name="language" id="language" class="mt-1 block w-full bg-background border border-primary rounded-md text-white px-3 py-2 shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
        </div>
        <div>
            <label for="quality" class="block text-sm font-medium text-gray-200">Qualité</label>
            <input type="text" name="quality" id="quality" class="mt-1 block w-full bg-background border border-primary rounded-md text-white px-3 py-2 shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
        <div>
            <label for="server_name" class="block text-sm font-medium text-gray-200">Nom du Serveur</label>
            <input type="text" name="server_name" id="server_name" class="mt-1 block w-full bg-background border border-primary rounded-md text-white px-3 py-2 shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>
        </div>
        <div>
            <label for="subtitle" class="block text-sm font-medium text-gray-200">Sous-titre (optionnel)</label>
            <input type="text" name="subtitle" id="subtitle" class="mt-1 block w-full bg-background border border-primary rounded-md text-white px-3 py-2 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
        </div>
    </div>

    <div class="flex items-center mt-4">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" id="is_active" value="1" class="h-4 w-4 text-primary bg-background border-primary rounded">
        <label for="is_active" class="ml-2 block text-sm text-gray-200">Actif</label>
    </div>

    <div class="flex justify-end mt-6 space-x-4">
        <a href="{{ route('admin.movies.edit', $movie->id) }}" class="bg-background text-text px-4 py-2 rounded border border-primary hover:bg-primary hover:text-background">Annuler</a>
        <button type="submit" class="px-4 py-2 bg-primary text-background rounded hover:bg-opacity-80">Ajouter</button>
    </div>
</form>
@endsection