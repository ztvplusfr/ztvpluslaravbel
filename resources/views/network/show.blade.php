<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $network->name }} - Chaîne</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text">
    <x-navbar :currentRoute="request()->route()->getName()" />

    <div class="w-full mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Network banner -->
        <div class="mb-8 mt-16">
            @if($network->logo)
                @php
                    $logoUrl = preg_match('/^https?:\/\//', $network->logo)
                        ? $network->logo
                        : asset('storage/' . $network->logo);
                @endphp
                <img src="{{ $logoUrl }}" alt="{{ $network->name }} logo" class="w-40 h-20 object-contain object-left rounded">
            @endif
        </div>
        <!-- Horizontal tabs -->
        <div class="border-b border-gray-700 mb-6">
            <nav class="flex space-x-8">
                <button id="tab-films" class="pb-2 border-b-2 border-primary text-white font-semibold focus:outline-none">Films</button>
                <button id="tab-series" class="pb-2 border-b-2 border-transparent text-gray-400 hover:text-white hover:border-gray-300 font-semibold focus:outline-none">Séries</button>
            </nav>
        </div>
        <div>
                <div id="content-films" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-7 gap-4">
                    @if($network->movies->isNotEmpty())
                        @foreach($network->movies as $movie)
                            <a href="{{ route('movies.show', $movie->id) }}" class="group block relative">
                                @if($movie->poster_path)
                                    <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="w-full aspect-[2/3] object-cover object-center rounded">
                                @else
                                    <div class="w-full aspect-[2/3] bg-gray-800 flex items-center justify-center rounded">
                                        <span class="text-white text-sm">Pas d'image</span>
                                    </div>
                                @endif
                                <!-- Overlay on hover -->
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-white text-sm mt-2 font-medium truncate">{{ $movie->title }}</h3>
                            </a>
                        @endforeach
                    @else
                        <p class="text-white">Aucun film disponible pour cette chaîne.</p>
                    @endif
                </div>
                <div id="content-series" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-7 gap-4">
                    @if($network->series->isNotEmpty())
                        @foreach($network->series as $serie)
                            <a href="{{ route('series.show', $serie->id) }}" class="group block relative">
                                @if($serie->poster_path)
                                    <img src="https://image.tmdb.org/t/p/w500{{ $serie->poster_path }}" alt="{{ $serie->title }}" class="w-full aspect-[2/3] object-cover object-center rounded">
                                @else
                                    <div class="w-full aspect-[2/3] bg-gray-800 flex items-center justify-center rounded">
                                        <span class="text-white text-sm">Pas d'image</span>
                                    </div>
                                @endif
                                <!-- Overlay on hover -->
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-white text-sm mt-2 font-medium truncate">{{ $serie->title }}</h3>
                            </a>
                        @endforeach
                    @else
                        <p class="text-white">Aucune série disponible pour cette chaîne.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
    // Tab functionality
    const tabFilms = document.getElementById('tab-films');
    const tabSeries = document.getElementById('tab-series');
    const contentFilms = document.getElementById('content-films');
    const contentSeries = document.getElementById('content-series');

    tabFilms.addEventListener('click', () => {
        contentFilms.classList.remove('hidden');
        contentSeries.classList.add('hidden');
        tabFilms.classList.remove('border-transparent');
        tabFilms.classList.add('border-primary', 'text-white');
        tabSeries.classList.remove('border-primary', 'text-white');
        tabSeries.classList.add('border-transparent', 'text-gray-400');
    });

    tabSeries.addEventListener('click', () => {
        contentSeries.classList.remove('hidden');
        contentFilms.classList.add('hidden');
        tabSeries.classList.remove('border-transparent');
        tabSeries.classList.add('border-primary', 'text-white');
        tabFilms.classList.remove('border-primary', 'text-white');
        tabFilms.classList.add('border-transparent', 'text-gray-400');
    });
    </script>
</body>
</html>