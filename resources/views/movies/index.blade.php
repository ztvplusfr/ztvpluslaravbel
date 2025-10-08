<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZTV Plus - Films</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text">
    <x-navbar :currentRoute="request()->route()->getName()" />

    <main class="pt-20">
        <!-- Header Section -->
        <div class="relative w-full bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-left">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Films</h1>
                <p class="text-lg text-gray-300 mb-8 max-w-2xl">Découvrez notre collection complète de films, de l'action au romantique, en passant par la comédie et le drame.</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="min-h-screen">
            @if($movies && $movies->isNotEmpty())
                <!-- All Movies Section -->
                <section class="py-8 w-full px-0 sm:px-6 lg:px-0 lg:pl-12 mx-0">
                    <h2 class="text-white text-2xl font-bold mb-6 ml-4 lg:ml-0">Tous les films</h2>
                    <div class="overflow-x-auto scrollbar-hide pb-4">
                        <div class="flex space-x-4 px-4 lg:px-0 min-w-max">
                            @foreach($movies as $movie)
                                <a href="{{ route('movies.show', $movie->id) }}" class="flex-shrink-0 w-48 sm:w-52 md:w-56 relative group block">
                                    @if($movie->poster_path)
                                        <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="w-full h-auto aspect-[2/3] object-cover rounded-lg">
                                    @else
                                        <div class="w-full aspect-[2/3] bg-gray-800 flex items-center justify-center rounded-lg">
                                            <span class="text-white text-sm">Image non disponible</span>
                                        </div>
                                    @endif
                                    <!-- Hover overlay -->
                                    <div class="absolute inset-0 bg-black bg-opacity-70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                                        <svg class="w-12 h-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <h3 class="text-white text-sm mt-2 font-medium">{{ $movie->title }}</h3>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </section>
            @else
                <div class="flex items-center justify-center min-h-96">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-xl font-medium text-gray-300 mb-2">Aucun film disponible</h3>
                        <p class="text-gray-400">Nous travaillons à ajouter de nouveaux films à notre collection.</p>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <x-bottom-nav :currentRoute="request()->route()->getName()" />
</body>
</html>
