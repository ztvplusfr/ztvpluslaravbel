<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ZTV Plus - Ma Liste</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text min-h-screen">
    <x-navbar :currentRoute="request()->route()->getName()" />

    <!-- Header Section -->
    <div class="relative w-full bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="text-left">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Ma Liste</h1>
            <p class="text-lg text-gray-300 mb-8 max-w-2xl">Gérez vos films et séries que vous voulez regarder, êtes en train de regarder ou avez terminé.</p>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="py-8 w-full px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap gap-4 mb-8 justify-center">
            @foreach($types as $key => $label)
                <a href="{{ route('watchlist.index', ['type' => $key]) }}"
                   class="px-4 py-2 rounded-full {{ $type === $key ? 'bg-primary text-background' : 'bg-white/10 text-white hover:bg-white/20' }} transition">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Items Section -->
    <section class="w-full px-4 sm:px-6 lg:px-8 pb-8">
        @if(empty($formattedGroups))
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <h3 class="text-xl font-medium text-gray-300 mb-2">Votre liste est vide</h3>
                <p class="text-gray-400 mb-6">Ajouter des films et séries à votre liste pour commencer à les suivre.</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('movies.index') }}" class="bg-primary text-background px-6 py-3 rounded-lg hover:bg-opacity-80 transition">
                        Parcourir les films
                    </a>
                    <a href="{{ route('series.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-500 transition">
                        Parcourir les séries
                    </a>
                </div>
            </div>
        @else
            @foreach($formattedGroups as $date => $watchlistsInGroup)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-white mb-6">{{ $date }}</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-6">
                        @foreach($watchlistsInGroup as $watchlist)
                            @php
                                $item = $watchlist->watchable;
                            @endphp
                            <div class="relative group">
                                <a href="{{ $item instanceof \App\Models\Movie ? route('movies.show', $item->id) : route('series.show', $item->id) }}" class="block">
                                    @if($item->poster_path)
                                        <img src="https://image.tmdb.org/t/p/w300{{ $item->poster_path }}" alt="{{ $item->title }}" class="w-full h-auto aspect-[2/3] object-cover rounded-lg shadow-md">
                                    @else
                                        <div class="w-full aspect-[2/3] bg-gray-800 flex items-center justify-center rounded-lg shadow-md">
                                            <span class="text-white text-sm">Image non disponible</span>
                                        </div>
                                    @endif
                                </a>

                                <!-- Rating if present -->
                                @if($watchlist->rating)
                                    <span class="absolute top-2 right-2 bg-yellow-500 text-black text-xs px-2 py-1 rounded font-bold">
                                        {{ $watchlist->rating }}/10
                                    </span>
                                @endif

                                <!-- Hover overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg p-4 flex flex-col justify-end">
                                    <div>
                                        <h3 class="text-white text-lg font-semibold mb-1">{{ $item->title }}</h3>
                                        <div class="flex flex-wrap gap-1 mb-4">
                                            <span class="bg-primary text-background text-xs px-2 py-1 rounded">{{ $item instanceof \App\Models\Movie ? 'Film' : 'Série' }}</span>
                                            @if($item instanceof \App\Models\Movie && $item->duration)
                                                <span class="bg-white/20 text-white text-xs px-2 py-1 rounded">{{ floor($item->duration / 60) }}h {{ $item->duration % 60 }}m</span>
                                            @endif
                                            @if($item->genres && is_array($item->genres))
                                                @foreach(array_slice($item->genres, 0, 1) as $genre)
                                                    <span class="bg-white/20 text-white text-xs px-2 py-1 rounded">{{ $genre }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="flex justify-between">
                                            <a href="{{ $item instanceof \App\Models\Movie ? route('movies.show', $item->id) : route('series.show', $item->id) }}" class="bg-primary text-background px-3 py-1 rounded hover:bg-opacity-80 transition text-xs">
                                                Regarder
                                            </a>
                                            <button onclick="removeFromWatchlist({{ $item->id }}, '{{ $item instanceof \App\Models\Movie ? 'movie' : 'series' }}')" class="text-gray-300 hover:text-white text-xs px-3 py-1 rounded bg-white/10 hover:bg-white/20 transition">
                                                Supprimer
                                            </button>
                                        </div>
                                        @if($watchlist->notes)
                                            <p class="text-gray-300 text-xs mt-2">{{ Str::limit($watchlist->notes, 100) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </section>
    <script>
        function removeFromWatchlist(id, type) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet élément de votre liste ?')) {
                fetch('/watchlist/update', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: id,
                        type: type,
                        status: 'remove'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message && data.in_watchlist === false) {
                        location.reload(); // Reload to update the view
                    } else {
                        alert('Erreur lors de la suppression : ' + (data.message || 'Erreur inconnue'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue lors de la suppression.');
                });
            }
        }
    </script>

    <x-bottom-nav :currentRoute="request()->route()->getName()" />
</body>
</html>
