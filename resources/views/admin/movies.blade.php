<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Administration - Films</title>
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
             <h1 class="text-3xl font-bold text-primary mb-6">Gestion des Films</h1>
             <p class="mb-4">Bienvenue, {{ Auth::user()->name }} ! Voici la liste des films.</p>

             <!-- Liste des films en tableau -->
             <div class="w-full overflow-x-auto">
                 <table class="w-full bg-background rounded-lg">
                     <thead>
                         <tr class="bg-primary">
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">#</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Poster</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Titre</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Status</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Année</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Genre</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Actions</th>
                         </tr>
                     </thead>
                     <tbody class="divide-y divide-primary">
                         @foreach($movies as $index => $movie)
                         <tr class="bg-background hover:bg-primary hover:bg-opacity-10">
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-text">{{ $index + 1 }}</td>
                             <td class="px-4 py-4 whitespace-nowrap text-center">
                                 @if($movie->poster_path)
                                 <img src="https://image.tmdb.org/t/p/w92{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="w-12 h-16 object-cover">
                                 @else
                                 <div class="w-12 h-16 bg-background flex items-center justify-center text-xs text-text">N/A</div>
                                 @endif
                             </td>
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-text">{{ $movie->title }}</td>
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                 @if($movie->is_active)
                                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-background">Actif</span>
                                 @else
                                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-background text-text border border-primary">Inactif</span>
                                 @endif
                             </td>
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-text">{{ $movie->release_date ? $movie->release_date->format('Y') : 'N/A' }}</td>
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-text">{{ $movie->genres ? implode(', ', $movie->genres) : 'N/A' }}</td>
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                 <div class="flex justify-center space-x-2">
                                     <a href="{{ route('admin.movies.edit', $movie->id) }}" class="bg-primary text-background px-3 py-1 rounded text-xs font-medium hover:bg-opacity-80">Modifier</a>
                                     <button class="bg-red-500 text-white px-3 py-1 rounded text-xs font-medium hover:bg-red-600">Supprimer</button>
                                 </div>
                             </td>
                         @endforeach
                     </tbody>
                 </table>
             </div>

             @if($movies->isEmpty())
             <p class="text-gray-400 mt-4">Aucun film trouvé.</p>
             @endif
         </main>
     </div>
 </body>
</html>