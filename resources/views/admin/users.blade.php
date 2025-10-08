<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Administration - Utilisateurs</title>
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
             <h1 class="text-3xl font-bold text-primary mb-6">Gestion des Utilisateurs</h1>
             <p class="mb-4">Bienvenue, {{ Auth::user()->name }} ! Voici la liste des utilisateurs.</p>

             <!-- Liste des utilisateurs en tableau -->
             <div class="w-full overflow-x-auto">
                 <table class="w-full bg-background rounded-lg">
                     <thead>
                         <tr class="bg-primary">
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">#</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Avatar</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Nom</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Email</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Rôle</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Actif</th>
                             <th class="px-4 py-3 text-center text-xs font-medium text-background uppercase tracking-wider">Actions</th>
                         </tr>
                     </thead>
                     <tbody class="divide-y divide-primary">
                         @foreach($users as $index => $user)
                         <tr class="bg-background hover:bg-primary hover:bg-opacity-10">
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-text">{{ $index + 1 }}</td>
                             <td class="px-4 py-4 whitespace-nowrap text-center">
                                 <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover">
                             </td>
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-text">{{ $user->name }}</td>
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-text">{{ $user->email }}</td>
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-text">{{ $user->role }}</td>
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                 @if($user->is_active)
                                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-background">Actif</span>
                                 @else
                                 <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-background text-text border border-primary">Inactif</span>
                                 @endif
                             </td>
                             <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                 <div class="flex justify-center space-x-2">
                                     <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-primary text-background px-3 py-1 rounded text-xs font-medium hover:bg-opacity-80">Modifier</a>
                                     <button class="bg-red-500 text-white px-3 py-1 rounded text-xs font-medium hover:bg-red-600">Supprimer</button>
                                 </div>
                             </td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>

             @if($users->isEmpty())
             <p class="text-gray-400 mt-4">Aucun utilisateur trouvé.</p>
             @endif
         </main>
     </div>
 </body>
</html>