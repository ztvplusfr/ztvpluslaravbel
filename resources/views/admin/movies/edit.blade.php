<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Administration - Éditer Film</title>
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
                        <a href="#" class="block flex items-center px-4 py-3 text-white hover:bg-gray-700 hover:text-primary rounded mb-2">
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
             <h1 class="text-3xl font-bold text-primary mb-6">Éditer le Film</h1>
             <p class="mb-4">Bienvenue, {{ Auth::user()->name }} ! Modifiez les informations du film ci-dessous.</p>

             <!-- Aperçu des images -->
             <div class="flex justify-center items-start space-x-8 mb-6">
                 <div>
                     @if($movie->backdrop_path)
                     <img src="https://image.tmdb.org/t/p/w500{{ $movie->backdrop_path }}" alt="Backdrop de {{ $movie->title }}" class="w-80 h-45 object-cover rounded">
                     @else
                     <div class="w-80 h-45 bg-background border border-primary rounded flex items-center justify-center text-text">Aucun Backdrop</div>
                     @endif
                 </div>
                 <div>
                     @if($movie->poster_path)
                     <img src="https://image.tmdb.org/t/p/w342{{ $movie->poster_path }}" alt="Poster de {{ $movie->title }}" class="w-40 h-60 object-cover rounded">
                     @else
                     <div class="w-40 h-60 bg-background border border-primary rounded flex items-center justify-center text-text">Aucun Poster</div>
                     @endif
                 </div>
             </div>

             <h2 class="text-2xl font-bold text-primary mb-6">{{ $movie->title }}</h2>

             <!-- Action Buttons -->
             <div class="mb-6 flex space-x-4">
                 <a href="/movies/{{ $movie->id }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Voir la fiche du film</a>
                 <a href="/play/movies/{{ $movie->id }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Regarder le film</a>
             </div>

             <form action="/admin/movies/{{ $movie->id }}" method="POST" class="bg-background p-6 rounded-lg border border-primary">
                 @csrf
                 @method('PUT')

                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                         <label for="tmdb_id" class="block text-sm font-medium text-text">TMDB ID</label>
                         <input type="number" id="tmdb_id" name="tmdb_id" value="{{ $movie->tmdb_id }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" readonly>
                     </div>

                     <div>
                         <label for="title" class="block text-sm font-medium text-text">Titre</label>
                         <input type="text" id="title" name="title" value="{{ $movie->title }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" required>
                     </div>

                     <div>
                         <label for="original_title" class="block text-sm font-medium text-text">Titre Original</label>
                         <input type="text" id="original_title" name="original_title" value="{{ $movie->original_title }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="language" class="block text-sm font-medium text-text">Langue</label>
                         <input type="text" id="language" name="language" value="{{ $movie->language }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="release_date" class="block text-sm font-medium text-text">Date de Sortie</label>
                         <input type="date" id="release_date" name="release_date" value="{{ $movie->release_date ? $movie->release_date->format('Y-m-d') : '' }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="genres" class="block text-sm font-medium text-text">Genres (séparés par des virgules)</label>
                         <input type="text" id="genres" name="genres" value="{{ $movie->genres ? implode(', ', $movie->genres) : '' }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="poster_path" class="block text-sm font-medium text-text">URL Poster</label>
                         <input type="url" id="poster_path" name="poster_path" value="{{ $movie->poster_path }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="backdrop_path" class="block text-sm font-medium text-text">URL Backdrop</label>
                         <input type="url" id="backdrop_path" name="backdrop_path" value="{{ $movie->backdrop_path }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="popularity" class="block text-sm font-medium text-text">Popularité</label>
                         <input type="number" step="0.01" id="popularity" name="popularity" value="{{ $movie->popularity }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="vote_average" class="block text-sm font-medium text-text">Note Moyenne</label>
                         <input type="number" step="0.1" id="vote_average" name="vote_average" value="{{ $movie->vote_average }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="vote_count" class="block text-sm font-medium text-text">Nombre de Votes</label>
                         <input type="number" id="vote_count" name="vote_count" value="{{ $movie->vote_count }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div class="flex items-center">
                         <input type="checkbox" id="is_active" name="is_active" value="1" {{ $movie->is_active ? 'checked' : '' }} class="h-4 w-4 text-primary bg-background border-primary rounded">
                         <label for="is_active" class="ml-2 block text-sm text-text">Actif</label>
                     </div>
                 </div>

                 <div class="mt-6">
                     <label for="overview" class="block text-sm font-medium text-text">Synopsis</label>
                     <textarea id="overview" name="overview" rows="4" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">{{ $movie->overview }}</textarea>
                 </div>

                 <div class="mt-6">
                     <label for="trailer_id" class="block text-sm font-medium text-text">ID Trailer YouTube</label>
                     <input type="text" id="trailer_id" name="trailer_id" value="{{ $movie->trailer_id }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" placeholder="Ex: dQw4w9WgXcQ">
                 </div>

                 <div class="mt-6">
                     <label for="age_rating" class="block text-sm font-medium text-text">Classification d'Âge</label>
                     <input type="text" id="age_rating" name="age_rating" value="{{ $movie->age_rating }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" placeholder="Ex: 12 ans">
                 </div>

                 <div class="mt-6 flex justify-end space-x-4">
                     <a href="{{ route('admin.movies') }}" class="bg-background text-text px-4 py-2 rounded border border-primary hover:bg-primary hover:text-background">Annuler</a>
                     <button type="submit" class="bg-primary text-background px-4 py-2 rounded hover:bg-opacity-80">Sauvegarder</button>
                 </div>
             </form>

             <!-- Section Vidéos -->
             <div class="mt-12">
                 <h2 class="text-2xl font-bold text-primary mb-4">Vidéos</h2>
                 <table class="w-full text-left border-collapse border border-primary">
                     <thead>
                         <tr>
                             <th class="border border-primary px-4 py-2">Serveur</th>
                             <th class="border border-primary px-4 py-2">Langue</th>
                             <th class="border border-primary px-4 py-2">Qualité</th>
                             <th class="border border-primary px-4 py-2">Sous-titre</th>
                             <th class="border border-primary px-4 py-2">Actif</th>
                             <th class="border border-primary px-4 py-2">Actions</th>
                         </tr>
                     </thead>
                     <tbody>
                         @forelse($movie->videos ?? [] as $video)
                         <tr>
                             <td class="border border-primary px-4 py-2">{{ $video->server_name }}</td>
                             <td class="border border-primary px-4 py-2">{{ $video->language }}</td>
                             <td class="border border-primary px-4 py-2">{{ $video->quality }}</td>
                             <td class="border border-primary px-4 py-2">{{ $video->subtitle ?? 'Aucun' }}</td>
                             <td class="border border-primary px-4 py-2">{{ $video->is_active ? 'Oui' : 'Non' }}</td>
                             <td class="border border-primary px-4 py-2">
                                 <a href="{{ route('admin.movies.videos.edit', ['movie' => $movie->id, 'video' => $video->id]) }}" class="text-primary hover:underline">Modifier</a>
                                 <form action="{{ route('admin.movies.videos.destroy', ['movie' => $movie->id, 'video' => $video->id]) }}" method="POST" class="inline">
                                     @csrf
                                     @method('DELETE')
                                     <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                                 </form>
                             </td>
                         </tr>
                         @empty
                         <tr>
                             <td colspan="6" class="border border-primary px-4 py-2 text-center">Aucune vidéo disponible.</td>
                         </tr>
                         @endforelse
                     </tbody>
                 </table>

                 <div class="mt-4">
                     <a href="{{ route('admin.movies.videos.create', ['movie' => $movie->id]) }}" class="bg-primary text-background px-4 py-2 rounded hover:bg-opacity-80">Ajouter une Vidéo</a>
                 </div>
             </div>
         </main>
     </div>
 </body>
</html>