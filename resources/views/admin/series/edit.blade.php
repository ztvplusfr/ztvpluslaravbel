<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Administration - Éditer Série</title>
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
             <h1 class="text-3xl font-bold text-primary mb-6">Éditer la Série</h1>
             <p class="mb-4">Bienvenue, {{ Auth::user()->name }} ! Modifiez les informations de la série ci-dessous.</p>

             <!-- Aperçu des images -->
             <div class="flex justify-center items-start space-x-8 mb-6">
                 <div>
                     @if($serie->backdrop_path)
                     <img src="https://image.tmdb.org/t/p/w500{{ $serie->backdrop_path }}" alt="Backdrop de {{ $serie->title }}" class="w-80 h-45 object-cover rounded">
                     @else
                     <div class="w-80 h-45 bg-background border border-primary rounded flex items-center justify-center text-text">Aucun Backdrop</div>
                     @endif
                 </div>
                 <div>
                     @if($serie->poster_path)
                     <img src="https://image.tmdb.org/t/p/w342{{ $serie->poster_path }}" alt="Poster de {{ $serie->title }}" class="w-40 h-60 object-cover rounded">
                     @else
                     <div class="w-40 h-60 bg-background border border-primary rounded flex items-center justify-center text-text">Aucun Poster</div>
                     @endif
                 </div>
             </div>

             <h2 class="text-2xl font-bold text-primary mb-6">{{ $serie->title }}</h2>

             <form action="#" method="POST" class="bg-background p-6 rounded-lg border border-primary">
                 @csrf
                 @method('PUT')

                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                         <label for="tmdb_id" class="block text-sm font-medium text-text">TMDB ID</label>
                         <input type="number" id="tmdb_id" name="tmdb_id" value="{{ $serie->tmdb_id }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" readonly>
                     </div>

                     <div>
                         <label for="title" class="block text-sm font-medium text-text">Titre</label>
                         <input type="text" id="title" name="title" value="{{ $serie->title }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" required>
                     </div>

                     <div>
                         <label for="original_title" class="block text-sm font-medium text-text">Titre Original</label>
                         <input type="text" id="original_title" name="original_title" value="{{ $serie->original_title }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="language" class="block text-sm font-medium text-text">Langue</label>
                         <input type="text" id="language" name="language" value="{{ $serie->language }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="first_air_date" class="block text-sm font-medium text-text">Première Diffusion</label>
                         <input type="date" id="first_air_date" name="first_air_date" value="{{ $serie->first_air_date ? $serie->first_air_date->format('Y-m-d') : '' }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="genres" class="block text-sm font-medium text-text">Genres (séparés par des virgules)</label>
                         <input type="text" id="genres" name="genres" value="{{ $serie->genres ? implode(', ', $serie->genres) : '' }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="poster_path" class="block text-sm font-medium text-text">URL Poster</label>
                         <input type="url" id="poster_path" name="poster_path" value="{{ $serie->poster_path }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="backdrop_path" class="block text-sm font-medium text-text">URL Backdrop</label>
                         <input type="url" id="backdrop_path" name="backdrop_path" value="{{ $serie->backdrop_path }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="popularity" class="block text-sm font-medium text-text">Popularité</label>
                         <input type="number" step="0.01" id="popularity" name="popularity" value="{{ $serie->popularity }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="vote_average" class="block text-sm font-medium text-text">Note Moyenne</label>
                         <input type="number" step="0.1" id="vote_average" name="vote_average" value="{{ $serie->vote_average }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="vote_count" class="block text-sm font-medium text-text">Nombre de Votes</label>
                         <input type="number" id="vote_count" name="vote_count" value="{{ $serie->vote_count }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div class="flex items-center">
                         <input type="checkbox" id="is_active" name="is_active" value="1" {{ $serie->is_active ? 'checked' : '' }} class="h-4 w-4 text-primary bg-background border-primary rounded">
                         <label for="is_active" class="ml-2 block text-sm text-text">Actif</label>
                     </div>
                 </div>

                 <div class="mt-6">
                     <label for="overview" class="block text-sm font-medium text-text">Synopsis</label>
                     <textarea id="overview" name="overview" rows="4" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">{{ $serie->overview }}</textarea>
                 </div>

                 <div class="mt-6 flex justify-end space-x-4">
                     <a href="{{ route('admin.series') }}" class="bg-background text-text px-4 py-2 rounded border border-primary hover:bg-primary hover:text-background">Annuler</a>
                     <button type="submit" class="bg-primary text-background px-4 py-2 rounded hover:bg-opacity-80">Sauvegarder</button>
                 </div>
             </form>

             <!-- Section Saisons -->
             <div class="mt-8">
                 <h3 class="text-xl font-bold text-primary mb-4">Saisons</h3>
                 <div class="mb-4">
                     <button class="bg-primary text-background px-4 py-2 rounded hover:bg-opacity-80">Ajouter une Saison</button>
                 </div>
                 <div class="space-y-4">
                     @foreach($serie->seasons as $season)
                     <div class="bg-background p-4 rounded-lg border border-primary">
                         <div class="flex justify-between items-center mb-2">
                             <h4 class="text-lg font-semibold text-text">Saison {{ $season->season_number }}: {{ $season->title }}</h4>
                             <div class="space-x-2">
                                 <a href="{{ route('admin.seasons.edit', $season->id) }}" class="bg-primary text-background px-3 py-1 rounded text-sm hover:bg-opacity-80">Modifier</a>
                                 <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Supprimer</button>
                             </div>
                         </div>
                         <p class="text-sm text-text mb-2">{{ $season->overview }}</p>
                         <p class="text-sm text-text">Date de diffusion: {{ $season->air_date ? $season->air_date->format('d/m/Y') : 'N/A' }} | Actif: {{ $season->is_active ? 'Oui' : 'Non' }}</p>

                         <!-- Épisodes de la saison -->
                         <div class="mt-4">
                             <h5 class="text-md font-semibold text-primary mb-2">Épisodes</h5>
                             <div class="mb-2">
                                 <button class="bg-primary text-background px-3 py-1 rounded text-sm hover:bg-opacity-80">Ajouter un Épisode</button>
                             </div>
                             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                 @foreach($season->episodes as $episode)
                                 <div class="bg-gray-800 p-3 rounded border border-primary">
                                     <div class="flex justify-between items-center mb-1">
                                         <h6 class="text-sm font-medium text-text">Épisode {{ $episode->episode_number }}: {{ $episode->title }}</h6>
                                         <div class="space-x-1">
                                             <button class="bg-primary text-background px-2 py-1 rounded text-xs hover:bg-opacity-80">Mod</button>
                                             <button class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">Sup</button>
                                         </div>
                                     </div>
                                     <p class="text-xs text-text">{{ Str::limit($episode->overview, 100) }}</p>
                                     <p class="text-xs text-text">Diffusion: {{ $episode->air_date ? $episode->air_date->format('d/m/Y') : 'N/A' }} | Note: {{ $episode->vote_average }}/10</p>
                                 </div>
                                 @endforeach
                             </div>
                             @if($season->episodes->isEmpty())
                             <p class="text-sm text-text">Aucun épisode pour cette saison.</p>
                             @endif
                         </div>
                     </div>
                     @endforeach
                 </div>
                 @if($serie->seasons->isEmpty())
                 <p class="text-text">Aucune saison pour cette série.</p>
                 @endif
             </div>
         </main>
     </div>
 </body>
</html>