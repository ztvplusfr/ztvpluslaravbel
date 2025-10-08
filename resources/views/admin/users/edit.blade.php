<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Administration - Éditer Utilisateur</title>
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
             <h1 class="text-3xl font-bold text-primary mb-6">Éditer l'Utilisateur</h1>
             <p class="mb-4">Bienvenue, {{ Auth::user()->name }} ! Modifiez les informations de l'utilisateur ci-dessous.</p>

             <!-- Aperçu de l'avatar -->
             <div class="flex justify-center mb-6">
                 <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover">
             </div>

             <h2 class="text-2xl font-bold text-primary mb-6">{{ $user->name }}</h2>

             <form action="#" method="POST" class="bg-background p-6 rounded-lg border border-primary">
                 @csrf
                 @method('PUT')

                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                         <label for="name" class="block text-sm font-medium text-text">Nom</label>
                         <input type="text" id="name" name="name" value="{{ $user->name }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" required>
                     </div>

                     <div>
                         <label for="email" class="block text-sm font-medium text-text">Email</label>
                         <input type="email" id="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text" required>
                     </div>

                     <div>
                         <label for="role" class="block text-sm font-medium text-text">Rôle</label>
                         <select id="role" name="role" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                             <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur</option>
                             <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                         </select>
                     </div>

                     <div>
                         <label for="language" class="block text-sm font-medium text-text">Langue</label>
                         <input type="text" id="language" name="language" value="{{ $user->language }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="country" class="block text-sm font-medium text-text">Pays</label>
                         <input type="text" id="country" name="country" value="{{ $user->country }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="max_streams" class="block text-sm font-medium text-text">Streams Max</label>
                         <input type="number" id="max_streams" name="max_streams" value="{{ $user->max_streams }}" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>

                     <div>
                         <label for="profile_photo" class="block text-sm font-medium text-text">Photo de Profil</label>
                         <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="mt-1 block w-full px-3 py-2 bg-background border border-primary rounded-md text-text">
                     </div>
                 </div>

                 <div class="mt-6 flex justify-end space-x-4">
                     <a href="{{ route('admin.users') }}" class="bg-background text-text px-4 py-2 rounded border border-primary hover:bg-primary hover:text-background">Annuler</a>
                     <button type="submit" class="bg-primary text-background px-4 py-2 rounded hover:bg-opacity-80">Sauvegarder</button>
                 </div>
             </form>
         </main>
     </div>
 </body>
</html>