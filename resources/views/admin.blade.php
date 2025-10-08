<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Administration</title>
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
                        <a href="admin/import" class="block flex items-center px-4 py-3 text-white hover:bg-gray-700 hover:text-primary rounded mb-2">
                            <i class="ti ti-upload mr-3 text-2xl"></i> <span class="text-lg">Importer</span>
                        </a>
                    </li>
                 </ul>
             </nav>
         </aside>
         <!-- Contenu principal -->
         <main class="flex-1 p-8 h-screen overflow-y-auto">
             <h1 class="text-3xl font-bold text-primary mb-6">Zone d'administration</h1>
             <p class="mb-4">Bienvenue, {{ Auth::user()->name }} !</p>

             <!-- Statistiques -->
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                 <div class="bg-background border border-primary rounded-lg p-6 text-center">
                     <svg class="w-16 h-16 text-primary mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg>
                     <h3 class="text-2xl font-bold text-text">{{ $stats['users'] }}</h3>
                     <p class="text-text">Utilisateurs</p>
                 </div>
                 <div class="bg-background border border-primary rounded-lg p-6 text-center">
                     <svg class="w-16 h-16 text-primary mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-9 0V1m10 3V1m0 3l1 1v16a2 2 0 01-2 2H6a2 2 0 01-2-2V5l1-1z"></path></svg>
                     <h3 class="text-2xl font-bold text-text">{{ $stats['movies'] }}</h3>
                     <p class="text-text">Films</p>
                 </div>
                 <div class="bg-background border border-primary rounded-lg p-6 text-center">
                     <svg class="w-16 h-16 text-primary mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                     <h3 class="text-2xl font-bold text-text">{{ $stats['series'] }}</h3>
                     <p class="text-text">Séries</p>
                 </div>
                 <div class="bg-background border border-primary rounded-lg p-6 text-center">
                     <svg class="w-16 h-16 text-primary mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                     <h3 class="text-2xl font-bold text-text">{{ $stats['seasons'] }}</h3>
                     <p class="text-text">Saisons</p>
                 </div>
                 <div class="bg-background border border-primary rounded-lg p-6 text-center">
                     <svg class="w-16 h-16 text-primary mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l.707.707A1 1 0 0012.414 11H13a4 4 0 014 4v1a1 1 0 01-1 1H8a1 1 0 01-1-1v-1a4 4 0 014-4h.586a1 1 0 00.707-.293l.707-.707A1 1 0 0111.414 9H13m-4 2a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                     <h3 class="text-2xl font-bold text-text">{{ $stats['episodes'] }}</h3>
                     <p class="text-text">Épisodes</p>
                 </div>
             </div>

             <!-- Contenu admin ici -->
         </main>
     </div>
 </body>
</html>