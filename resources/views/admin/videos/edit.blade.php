@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold text-primary mb-4">Modifier une Vidéo</h1>

    <form action="{{ route('admin.movies.videos.update', ['movie' => $movie->id, 'video' => $video->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="embed_link" class="block text-sm font-medium text-gray-700">Lien d'intégration</label>
            <input type="url" name="embed_link" id="embed_link" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" value="{{ old('embed_link', $video->embed_link) }}" required>
        </div>

        <div class="mb-4">
            <label for="language" class="block text-sm font-medium text-gray-700">Langue</label>
            <input type="text" name="language" id="language" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" value="{{ old('language', $video->language) }}" required>
        </div>

        <div class="mb-4">
            <label for="quality" class="block text-sm font-medium text-gray-700">Qualité</label>
            <input type="text" name="quality" id="quality" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" value="{{ old('quality', $video->quality) }}" required>
        </div>

        <div class="mb-4">
            <label for="server_name" class="block text-sm font-medium text-gray-700">Nom du Serveur</label>
            <input type="text" name="server_name" id="server_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" value="{{ old('server_name', $video->server_name) }}" required>
        </div>

        <div class="mb-4">
            <label for="subtitle" class="block text-sm font-medium text-gray-700">Sous-titre (optionnel)</label>
            <input type="text" name="subtitle" id="subtitle" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary sm:text-sm" value="{{ old('subtitle', $video->subtitle) }}">
        </div>

        <div class="mb-4">
            <label for="is_active" class="block text-sm font-medium text-gray-700">Actif</label>
            <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', $video->is_active) ? 'checked' : '' }}>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection