<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Administration - Éditer Saison</title>
     @vite('resources/css/app.css')
    <!-- Tabler Icons -->
    <link href="https://unpkg.com/tabler-icons@latest/iconfont/tabler-icons.min.css" rel="stylesheet">
 </head>
 <body class="bg-background text-white">
     <div class="min-h-screen flex">
         <!-- Sidebar Admin -->
         <aside class="w-64 h-screen bg-background p-6">
             <div class="mb-8 flex justify-center">
                 <img class="h-12 w-auto" src="{{ asset('brand/logo.png') }}" alt="Logo" />
             </div>
             <nav>
                 <ul>
                    <li>
                        <a href="{{ route('admin') }}" class="block flex items-center px-4 py-3 text-white hover:bg-gray-700 hover:text-primary rounded mb-2">
                            <i class="ti ti-home mr-3 text-2xl"></i>
                            <span class="text-lg">Accueil</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.series') }}" class="block flex items-center px-4 py-3 text-white hover:bg-gray-700 hover:text-primary rounded mb-2">
                            <i class="ti ti-device-tv mr-3 text-2xl"></i> <span class="text-lg">Séries</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.movies') }}" class="block flex items-center px-4 py-3 text-white hover:bg-gray-700 hover:text-primary rounded mb-2">
                            <i class="ti ti-movie mr-3 text-2xl"></i> <span class="text-lg">Films</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" class="block flex items-center px-4 py-3 text-white hover:bg-gray-700 hover:text-primary rounded mb-2">
                            <i class="ti ti-users mr-3 text-2xl"></i> <span class="text-lg">Utilisateurs</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block flex items-center px-4 py-3 text-white hover:bg-gray-700 hover:text-primary rounded mb-2">
                            <i class="ti ti-world mr-3 text-2xl"></i> <span class="text-lg">Site</span>
                        </a>
                    </li>
                    <!-- Importer -->
                    <li>
                        <a href="{{ route('admin.import.form') }}" class="block flex items-center px-4 py-3 text-white hover:bg-gray-700 hover:text-primary rounded mb-2">
                            <i class="ti ti-upload mr-3 text-2xl"></i> <span class="text-lg">Importer</span>
                        </a>
                    </li>
                 </ul>
             </nav>
         </aside>
         <!-- Contenu principal -->
         <main class="flex-1 p-8 h-screen overflow-y-auto">
             <h1 class="text-3xl font-bold text-primary mb-6">Éditer la Saison</h1>
             <p class="mb-4">Bienvenue, {{ Auth::user()->name }} ! Modifiez les informations de la saison ci-dessous.</p>

             <!-- Aperçu du poster -->
             <div class="flex justify-center mb-6">
                 <div>
                     @if($season->poster_path)
                     <img src="https://image.tmdb.org/t/p/w342{{ $season->poster_path }}" alt="Poster de {{ $season->title }}" class="w-40 h-60 object-cover rounded">
                     @else
                     <div class="w-40 h-60 bg-background border border-primary rounded flex items-center justify-center text-text">Aucun Poster</div>
                     @endif
                 </div>
             </div>

             <h2 class="text-2xl font-bold text-primary mb-6">{{ $season->title }}</h2>

             <form action="#" method="POST" class="bg-background p-6 rounded-lg border border-primary">
                 @csrf
                 @method('PUT')

                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                         <label for="series_id" class="block text-sm font-medium text-text">Série ID</label>
                         <input type="number" id="series_id" name="series_id" value="{{ $season->series_id }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" readonly>
                     </div>

                     <div>
                         <label for="season_number" class="block text-sm font-medium text-text">Numéro de Saison</label>
                         <input type="number" id="season_number" name="season_number" value="{{ $season->season_number }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" required>
                     </div>

                     <div>
                         <label for="title" class="block text-sm font-medium text-text">Titre</label>
                         <input type="text" id="title" name="title" value="{{ $season->title }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" required>
                     </div>

                     <div>
                         <label for="air_date" class="block text-sm font-medium text-text">Date de Diffusion</label>
                         <input type="date" id="air_date" name="air_date" value="{{ $season->air_date ? $season->air_date->format('Y-m-d') : '' }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="poster_path" class="block text-sm font-medium text-text">URL Poster</label>
                         <input type="url" id="poster_path" name="poster_path" value="{{ $season->poster_path }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div class="flex items-center">
                         <input type="checkbox" id="is_active" name="is_active" value="1" {{ $season->is_active ? 'checked' : '' }} class="h-4 w-4 text-primary bg-background border-primary rounded">
                         <label for="is_active" class="ml-2 block text-sm text-text">Actif</label>
                     </div>
                 </div>

                 <div class="mt-6">
                     <label for="overview" class="block text-sm font-medium text-text">Synopsis</label>
                     <textarea id="overview" name="overview" rows="4" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">{{ $season->overview }}</textarea>
                 </div>

                 <div class="mt-6 flex justify-end space-x-4">
                     <a href="{{ route('admin.series.edit', $season->series_id) }}" class="bg-background text-text px-4 py-2 rounded border border-primary hover:bg-primary hover:text-background">Annuler</a>
                     <button type="submit" class="bg-primary text-background px-4 py-2 rounded hover:bg-opacity-80">Sauvegarder</button>
                 </div>
             </form>

             <!-- Section Épisodes -->
             <div class="mt-8">
                 <h3 class="text-xl font-bold text-primary mb-4">Épisodes</h3>
                 <div class="mb-4">
                     <button class="bg-primary text-background px-4 py-2 rounded hover:bg-opacity-80">Ajouter un Épisode</button>
                 </div>
                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                     @foreach($season->episodes as $episode)
                     <div class="bg-gray-800 p-3 rounded border border-primary">
                         <div class="flex justify-between items-center mb-1">
                             <h6 class="text-sm font-medium text-text">Épisode {{ $episode->episode_number }}: {{ $episode->title }}</h6>
                             <div class="space-x-1">
                                 <a href="{{ route('admin.episodes.edit', $episode->id) }}" class="bg-primary text-background px-2 py-1 rounded text-xs hover:bg-opacity-80">Mod</a>
                                 <button class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">Sup</button>
                             </div>
                         </div>
                         <p class="text-xs text-text">{{ Str::limit($episode->overview, 100) }}</p>
                         <p class="text-xs text-text">Diffusion: {{ $episode->air_date ? $episode->air_date->format('d/m/Y') : 'N/A' }} | Note: {{ $episode->vote_average }}/10</p>
                     </div>
                     @endforeach
                 </div>
                 @if($season->episodes->isEmpty())
                 <p class="text-text mt-4">Aucun épisode pour cette saison.</p>
                 @endif
             </div>
         </main>
     </div>
 </body>
</html>