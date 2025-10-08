<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lecture - {{ $movie->title }} – ZTV Plus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white">
    {{-- Mobile Version --}}
    <div class="block md:hidden">
    <div id="player-wrapper-mobile" class="min-h-screen bg-black text-white flex flex-col">
        @php
            $langMap = [
                'fr' => 'Français',
                'en' => 'Anglais',
                'es' => 'Espagnol',
                'de' => 'Allemand',
                'it' => 'Italien',
                'pt' => 'Portugais',
                'ja' => 'Japonais',
                'ko' => 'Coréen',
                'zh' => 'Chinois',
            ];
        @endphp
        <!-- Bouton Retour -->
        <div class="absolute top-4 left-4 z-50">
            <button class="bg-primary text-background rounded-full w-10 h-10 flex items-center justify-center hover:bg-primary/80 transition" onclick="history.back()" title="Retour">←</button>
        </div>
        <!-- Video Embed -->
        <div class="h-96 md:h-full relative">
            <iframe src="{{ $video->embed_link }}"
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
            </iframe>
        </div>
        <!-- Infos section -->
        <div class="bg-black/90 p-4">
            <!-- Backdrop cliquable -->
            <a href="{{ route('movies.show', $movie->id) }}"
               class="block h-40 bg-cover bg-center mb-4 mx-auto max-w-sm border-b-2 border-transparent hover:border-primary transition rounded"
               style="background-image: url('https://image.tmdb.org/t/p/original{{ $movie->backdrop_path }}')"
               title="Voir la fiche du film">
            </a>
            <h1 class="text-xl text-center font-bold uppercase hover:text-primary transition mb-4">
                <a href="{{ route('movies.show', $movie->id) }}">{{ $movie->title }}</a>
            </h1>
            <div class="flex flex-wrap justify-center items-center gap-2 text-xs mb-4">
                @if($movie->duration)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ floor($movie->duration/60) }}h {{ $movie->duration % 60 }}m</span>
                @endif
                @if($movie->release_date)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</span>
                @endif
                <span class="bg-white/20 px-2 py-1 rounded-full">{{ number_format($movie->vote_average,1) }}</span>
                @if($movie->age_rating)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ $movie->age_rating }}</span>
                @endif
                @foreach($movie->genres as $genre)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ $genre }}</span>
                @endforeach
            </div>
            <p class="text-sm leading-relaxed opacity-80 text-center mb-4">{{ $movie->overview }}</p>
            <p class="text-xl font-bold text-white mb-2 text-center">Source</p>
            <!-- Sélecteur de source (dropdown) en bas -->
            <div class="mt-4 flex justify-center">
                <select onchange="window.location.href=this.value" class="w-full max-w-sm bg-black/90 border border-white/40 text-white rounded-full px-4 py-2 focus:outline-none focus:border-primary">
                    @foreach($videos as $src)
                        <option value="{{ route('movie.play', ['id' => $movie->id, 'video' => $src->id]) }}" {{ $video->id == $src->id ? 'selected' : '' }}>
                            {{ $src->server_name ?? 'Source ' . ($loop->index + 1) }} · {{ $langMap[strtolower($src->language)] ?? ucfirst(strtolower($src->language)) }} ({{ $src->quality }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    </div>

    {{-- Desktop Version --}}
    <div class="hidden md:block">
    @php
        $langMap = [
            'fr' => 'Français',
            'en' => 'Anglais',
            'es' => 'Espagnol',
            'de' => 'Allemand',
            'it' => 'Italien',
            'pt' => 'Portugais',
            'ja' => 'Japonais',
            'ko' => 'Coréen',
            'zh' => 'Chinois',
        ];
    @endphp
    <div id="player-wrapper" class="fixed inset-0 bg-black flex">
        <!-- Bouton Retour -->
        <button class="absolute top-4 left-4 z-50 bg-primary text-background rounded-full w-10 h-10 flex items-center justify-center hover:bg-primary/80 transition" onclick="history.back()" title="Retour">←</button>
        <!-- Video Embed -->
        <div class="flex-1 relative">
            <iframe src="{{ $video->embed_link }}"
                    class="w-full h-full"
                    frameborder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
            </iframe>
        </div>
        <!-- Infos section -->
        <div id="movie-info" class="w-80 bg-gradient-to-t from-black/95 to-black/70 p-4 flex flex-col space-y-4 overflow-auto">
            <!-- Backdrop cliquable -->
            <a href="{{ route('movies.show', $movie->id) }}"
               class="block h-40 bg-cover bg-center mb-4 border-b-2 border-transparent hover:border-primary transition"
               style="background-image: url('https://image.tmdb.org/t/p/original{{ $movie->backdrop_path }}')"
               title="Voir la fiche du film">
            </a>
            <h1 class="text-xl font-bold uppercase hover:text-primary transition">
                <a href="{{ route('movies.show', $movie->id) }}">{{ $movie->title }}</a>
            </h1>
            <div class="flex flex-wrap items-center gap-2 text-xs">
                @if($movie->duration)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ floor($movie->duration/60) }}h {{ $movie->duration % 60 }}m</span>
                @endif
                @if($movie->release_date)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</span>
                @endif
                <span class="bg-white/20 px-2 py-1 rounded-full">{{ number_format($movie->vote_average,1) }}</span>
                @if($movie->age_rating)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ $movie->age_rating }}</span>
                @endif
                @foreach($movie->genres as $genre)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ $genre }}</span>
                @endforeach
            </div>
            <p class="text-sm leading-relaxed opacity-80">{{ $movie->overview }}</p>
            <p class="text-xl font-bold text-white mb-2">Source</p>
            <!-- Sélecteur de source (dropdown) en bas -->
            <div class="mt-4">
                <select onchange="window.location.href=this.value" class="w-full bg-black/90 border border-white/40 text-white rounded-full px-4 py-2 focus:outline-none focus:border-primary">
                    @foreach($videos as $src)
                        <option value="{{ route('movie.play', ['id' => $movie->id, 'video' => $src->id]) }}" {{ $video->id == $src->id ? 'selected' : '' }}>
                            {{ $src->server_name ?? 'Source ' . ($loop->index + 1) }} · {{ $langMap[strtolower($src->language)] ?? ucfirst(strtolower($src->language)) }} ({{ $src->quality }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</body>
</html>
