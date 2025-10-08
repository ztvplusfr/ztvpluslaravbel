<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Administration - Éditer Épisode</title>
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
             <h1 class="text-3xl font-bold text-primary mb-6">Éditer l'Épisode</h1>
             <p class="mb-4">Bienvenue, {{ Auth::user()->name }} ! Modifiez les informations de l'épisode ci-dessous.</p>

             <!-- Aperçu du still -->
             <div class="flex justify-center mb-6">
                 <div>
                     @if($episode->still_path)
                     <img src="https://image.tmdb.org/t/p/w500{{ $episode->still_path }}" alt="Still de {{ $episode->title }}" class="w-80 h-45 object-cover rounded">
                     @else
                     <div class="w-80 h-45 bg-background border border-primary rounded flex items-center justify-center text-text">Aucun Still</div>
                     @endif
                 </div>
             </div>

             <h2 class="text-2xl font-bold text-primary mb-6">{{ $episode->title }}</h2>

             <form action="#" method="POST" class="bg-background p-6 rounded-lg border border-primary">
                 @csrf
                 @method('PUT')

                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                         <label for="season_id" class="block text-sm font-medium text-text">Saison ID</label>
                         <input type="number" id="season_id" name="season_id" value="{{ $episode->season_id }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" readonly>
                     </div>

                     <div>
                         <label for="tmdb_id" class="block text-sm font-medium text-text">TMDB ID</label>
                         <input type="number" id="tmdb_id" name="tmdb_id" value="{{ $episode->tmdb_id }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" readonly>
                     </div>

                     <div>
                         <label for="episode_number" class="block text-sm font-medium text-text">Numéro d'Épisode</label>
                         <input type="number" id="episode_number" name="episode_number" value="{{ $episode->episode_number }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" required>
                     </div>

                     <div>
                         <label for="title" class="block text-sm font-medium text-text">Titre</label>
                         <input type="text" id="title" name="title" value="{{ $episode->title }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" required>
                     </div>

                     <div>
                         <label for="air_date" class="block text-sm font-medium text-text">Date de Diffusion</label>
                         <input type="date" id="air_date" name="air_date" value="{{ $episode->air_date ? $episode->air_date->format('Y-m-d') : '' }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="still_path" class="block text-sm font-medium text-text">URL Still</label>
                         <input type="url" id="still_path" name="still_path" value="{{ $episode->still_path }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="vote_average" class="block text-sm font-medium text-text">Note Moyenne</label>
                         <input type="number" step="0.1" id="vote_average" name="vote_average" value="{{ $episode->vote_average }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="vote_count" class="block text-sm font-medium text-text">Nombre de Votes</label>
                         <input type="number" id="vote_count" name="vote_count" value="{{ $episode->vote_count }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div class="flex items-center">
                         <input type="checkbox" id="is_active" name="is_active" value="1" {{ $episode->is_active ? 'checked' : '' }} class="h-4 w-4 text-primary bg-background border-primary rounded">
                         <label for="is_active" class="ml-2 block text-sm text-text">Actif</label>
                     </div>
                 </div>

                 <div class="mt-6">
                     <label for="overview" class="block text-sm font-medium text-text">Synopsis</label>
                     <textarea id="overview" name="overview" rows="4" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">{{ $episode->overview }}</textarea>
                 </div>

                 <div class="mt-6 flex justify-end space-x-4">
                     <a href="{{ route('admin.seasons.edit', $episode->season_id) }}" class="bg-background text-text px-4 py-2 rounded border border-primary hover:bg-primary hover:text-background">Annuler</a>
                     <button type="submit" class="bg-primary text-background px-4 py-2 rounded hover:bg-opacity-80">Sauvegarder</button>
                 </div>
             </form>
         </main>
     </div>
 </body>
</html>