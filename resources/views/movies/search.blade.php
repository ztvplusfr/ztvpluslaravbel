<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recherche de films – ZTV Plus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text min-h-screen">
    <x-navbar currentRoute="movies.search" />

    <main class="mt-16 container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-left mb-6 text-primary">Résultats de recherche</h1>
        <!-- Formulaire de recherche -->
    <form action="{{ route('movies.search') }}" method="get" class="w-full max-w-xl mx-auto mb-8 flex items-center">
            <input type="text" name="q" value="{{ $query }}" placeholder="Rechercher un film..."
                   class="flex-1 px-4 py-2 rounded-l-full bg-black/50 text-white placeholder-gray-400 focus:outline-none focus:bg-black focus:border-primary">
            <button type="submit" class="bg-primary text-background px-6 py-2 rounded-r-full hover:bg-primary/80 transition">Rechercher</button>
        </form>

        <!-- Carousel de résultats -->
        <div id="search-results">
        @if($movies->isEmpty())
            <p class="text-center text-white">Aucun film trouvé pour "{{ $query }}".</p>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6">
                @foreach($movies as $movie)
                    <div class="group relative">
                        <a href="{{ route('movies.show', $movie->id) }}" class="block">
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}"
                                 alt="{{ $movie->title }}"
                                 class="w-full h-auto object-cover">
                            <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 4l10 6-10 6V4z" />
                                </svg>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
        @if(isset($series) && $series->isNotEmpty())
            <h2 class="text-2xl font-bold text-left mb-4 text-primary">Séries trouvées</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6 mb-8">
                @foreach($series as $serie)
                    <div class="group relative">
                        <a href="{{ route('series.show', $serie->id) }}" class="block">
                            @if($serie->poster_path)
                                <img src="https://image.tmdb.org/t/p/w500{{ $serie->poster_path }}" alt="{{ $serie->title }}" class="w-full h-auto object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-800 flex items-center justify-center">
                                    <span class="text-white text-sm">Image non disponible</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 4l10 6-10 6V4z" />
                                </svg>
                            </div>
                        </a>
                        <h3 class="text-white text-sm mt-2 font-medium">{{ $serie->title }}</h3>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-white">Aucune série trouvée pour "{{ $query }}".</p>
        @endif
        </div>
    </main>

    <!-- Insert live search script -->
    <script>
        const input = document.querySelector('input[name="q"]');
        let timer;
        input.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(() => {
                const q = encodeURIComponent(this.value);
                fetch(`{{ route('movies.search') }}?q=${q}`)
                    .then(res => res.text())
                    .then(html => {
                        const tmp = document.createElement('div');
                        tmp.innerHTML = html;
                        const newResults = tmp.querySelector('#search-results');
                        document.querySelector('#search-results').innerHTML = newResults.innerHTML;
                    });
            }, 300);
        });
    </script>
</body>
</html>