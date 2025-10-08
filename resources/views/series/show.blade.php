<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $series->title }} – ZTV Plus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text min-h-screen">
    <x-navbar currentRoute="series.show" />

    {{-- Hero section mobile --}}
    <div class="block md:hidden">
        <div class="relative w-full h-[100vh] mb-8 bg-cover bg-center" style="background-image: url('https://image.tmdb.org/t/p/original{{ $series->backdrop_path }}')">
            <div class="absolute inset-0 bg-black/50"></div>
            <!-- Overlay gradient bas pour effet Netflix -->
            <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-black to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end h-full pr-0 pl-0 absolute bottom-0 w-full">
                <h1
                  class="text-2xl font-bold uppercase text-white mb-4 leading-tight line-clamp-2 max-w-full text-left">
                  {{ $series->title }}
                </h1>
                <div class="flex flex-wrap gap-2 text-xs text-white mb-6">
                    @if($series->release_year)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1.5 rounded-full space-x-1 text-sm font-semibold">
                            {{ $series->release_year }}
                        </span>
                    @endif
                    @if($series->seasons_count)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1.5 rounded-full space-x-1 text-sm font-semibold">
                            {{ $series->seasons_count }} saisons
                        </span>
                    @endif
                    @if($series->episodes_count)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1.5 rounded-full space-x-1 text-sm font-semibold">
                            {{ $series->episodes_count }} épisodes
                        </span>
                    @endif
                    @if($series->age_rating)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1.5 rounded-full space-x-1 text-sm font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <span>{{ $series->age_rating }}</span>
                        </span>
                    @endif
                    @if(!empty($series->genres))
                        @foreach($series->genres as $genre)
                            <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1.5 rounded-full space-x-1 text-sm font-semibold">
                                {{ $genre }}
                            </span>
                        @endforeach
                    @endif
                </div>

                <div class="flex flex-col space-y-2">
                    @php
                        $firstSeason = $series->seasons->first();
                        $firstEpisode = $firstSeason ? $firstSeason->episodes()->where('is_active', true)->first() : null;
                        $hasVideo = $firstEpisode && $firstEpisode->videos->isNotEmpty();
                    @endphp
                    <a href="{{ $hasVideo ? route('series.play', ['series_id' => $series->id, 'season_number' => $firstSeason->season_number, 'episode_number' => $firstEpisode->episode_number]) : '#' }}"
                        class="{{ $hasVideo ? 'bg-primary text-background hover:bg-opacity-80' : 'bg-gray-500 text-gray-300 cursor-not-allowed opacity-50' }} inline-flex w-full items-center justify-center px-6 py-3 text-lg font-semibold rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.5 5.5l7 4.5-7 4.5v-9z" />
                        </svg>
                        Regarder {{ $hasVideo ? 'S'.$firstSeason->season_number.'E'.$firstEpisode->episode_number : '' }}
                    </a>
                    <a href="#" class="inline-flex w-full items-center justify-center bg-gray-500 text-gray-300 border border-gray-500 cursor-not-allowed opacity-50 px-6 py-3 text-lg font-semibold rounded-full transition">
                        Bande annonce
                    </a>
                </div>

                {{-- Overview --}}
                <p class="text-white mt-12 max-w-2xl text-lg leading-relaxed line-clamp-3">
                    {{ $series->overview ?? 'Description non disponible.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Hero section desktop --}}
    <div class="hidden md:block">
        <div class="relative w-full h-[100vh] mb-8 bg-cover bg-center" style="background-image: url('https://image.tmdb.org/t/p/original{{ $series->backdrop_path }}')">
            <div class="absolute inset-0 bg-black/50"></div>
            <!-- Overlay gradient bas pour effet Netflix -->
            <div class="absolute inset-x-0 bottom-0 h-3/4 bg-gradient-to-t from-black to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end h-full p-8 absolute bottom-0 w-full">
                <h1
                  class="text-4xl md:text-5xl font-bold uppercase text-white mb-4 leading-tight line-clamp-2 max-w-2xl">
                  {{ $series->title }}
                </h1>
                <div class="flex items-center space-x-4 text-sm text-white mb-6">
                    @if($series->release_year)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-4 py-2 rounded-full space-x-2 text-base font-semibold">
                            {{ $series->release_year }}
                        </span>
                    @endif
                    @if($series->seasons_count)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-4 py-2 rounded-full space-x-2 text-base font-semibold">
                            {{ $series->seasons_count }} saisons
                        </span>
                    @endif
                    @if($series->episodes_count)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-4 py-2 rounded-full space-x-2 text-base font-semibold">
                            {{ $series->episodes_count }} épisodes
                        </span>
                    @endif
                    @if($series->age_rating)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-4 py-2 rounded-full space-x-2 text-base font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <span>{{ $series->age_rating }}</span>
                        </span>
                    @endif
                    @if(!empty($series->genres))
                        @foreach($series->genres as $genre)
                            <span class="inline-flex items-center justify-center bg-white/20 text-white px-4 py-2 rounded-full space-x-2 text-base font-semibold">
                                {{ $genre }}
                            </span>
                        @endforeach
                    @endif
                </div>
                <div class="flex items-center space-x-2">
                    @php
                        $firstSeason = $series->seasons->first();
                        $firstEpisode = $firstSeason ? $firstSeason->episodes()->where('is_active', true)->first() : null;
                        $hasVideo = $firstEpisode && $firstEpisode->videos->isNotEmpty();
                    @endphp
                    <a href="{{ $hasVideo ? route('series.play', ['series_id' => $series->id, 'season_number' => $firstSeason->season_number, 'episode_number' => $firstEpisode->episode_number]) : '#' }}"
                        class="{{ $hasVideo ? 'bg-primary text-background hover:bg-opacity-80' : 'bg-gray-500 text-gray-300 cursor-not-allowed opacity-50' }} inline-flex w-64 items-center justify-center px-6 py-3 text-lg font-semibold rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.5 5.5l7 4.5-7 4.5v-9z" />
                        </svg>
                        Regarder {{ $hasVideo ? 'S'.$firstSeason->season_number.'E'.$firstEpisode->episode_number : '' }}
                    </a>
                    <a href="#" class="inline-flex items-center justify-center bg-gray-500 text-gray-300 border border-gray-500 cursor-not-allowed opacity-50 px-6 py-3 rounded-full hover:bg-white/10 transition relative group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-movie">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                            <path d="M8 4l0 16" />
                            <path d="M16 4l0 16" />
                            <path d="M4 8l4 0" />
                            <path d="M4 16l4 0" />
                            <path d="M4 12l16 0" />
                            <path d="M16 8l4 0" />
                            <path d="M16 16l4 0" />
                        </svg>
                    </a>
                </div>
                <p class="text-white mt-12 max-w-2xl text-lg leading-relaxed">
                    {{ $series->overview ?? 'Description non disponible.' }}
                </p>
                @if($series->network && $series->network->logo)
                    @php
                        $logoUrl = preg_match('/^https?:\/\//', $series->network->logo)
                            ? $series->network->logo
                            : asset('storage/' . $series->network->logo);
                    @endphp
                    <div class="mt-6">
                        <a href="{{ route('networks.show', $series->network->id) }}">
                            <img src="{{ $logoUrl }}" alt="{{ $series->network->name }} logo" class="w-40 h-20 object-contain rounded">
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>


    {{-- Episode Section (Netflix style) --}}
    <section class="pr-0 pl-0 md:pl-8 mt-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-white">Épisodes</h2>
        <a href="?season={{ $selectedSeason->id }}&order={{ $orderDirection == 'asc' ? 'desc' : 'asc' }}" class="px-4 py-2 whitespace-nowrap rounded-full transition bg-white/20 text-white hover:bg-white/30 text-sm">
            {{ $orderDirection == 'asc' ? 'Inverser ordre' : 'Ordre normal' }}
        </a>
    </div>
        <!-- Saison tabs -->
        <div class="flex space-x-6 overflow-x-auto pb-4 mb-8">
            @foreach($series->seasons as $season)
                <a href="?season={{ $season->id }}" class="px-4 py-2 whitespace-nowrap rounded-full transition 
                    {{ $selectedSeason->id == $season->id ? 'bg-primary text-background' : 'bg-white/20 text-white hover:bg-white/30' }}">
                    Saison {{ $season->season_number }}
                </a>
            @endforeach
        </div>
    <!-- Episodes list -->
    <div class="space-y-8 pb-12">
            @forelse($episodes as $ep)
                {{-- Desktop layout --}}
                <div class="hidden md:flex items-end space-x-6">
                    <div class="relative">
                        <img src="https://image.tmdb.org/t/p/w500{{ $ep->still_path }}" alt="{{ $ep->title }}" class="w-64 h-auto object-cover rounded-lg">
                        <a href="{{ route('series.play', ['series_id' => $series->id, 'season_number' => $selectedSeason->season_number, 'episode_number' => $ep->episode_number]) }}" class="absolute inset-0 bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                    <div>
                        <p class="text-white text-lg font-semibold flex items-center space-x-2">
                            <span>Ép {{ $ep->episode_number }} - {{ $ep->title }}</span>
                            @if($ep->duration)
                                <span class="inline-flex items-center justify-center bg-white/20 text-white px-2 py-1 text-sm rounded-full">
                                    {{ $ep->duration }} min
                                </span>
                            @endif
                        </p>
                        @if($ep->overview)
                            <p class="text-gray-300 text-base mt-2 block md:hidden line-clamp-3">{{ $ep->overview }}</p>
                            <p class="text-gray-300 text-base mt-2 hidden md:block">{{ $ep->overview }}</p>
                        @endif
                        @if($ep->air_date)
                            <p class="text-gray-400 text-sm mt-1">Diffusé le {{ $ep->air_date->format('d M Y') }}</p>
                        @endif
                    </div>
                </div>
                {{-- Mobile layout --}}
                <div class="block md:hidden flex flex-col space-y-4">
                    <div class="relative">
                        <img src="https://image.tmdb.org/t/p/w500{{ $ep->still_path }}" alt="{{ $ep->title }}" class="w-full h-auto object-cover rounded-lg">
                        <a href="{{ route('series.play', ['series_id' => $series->id, 'season_number' => $selectedSeason->season_number, 'episode_number' => $ep->episode_number]) }}" class="absolute inset-0 bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        @if($ep->duration)
                            <span class="absolute bottom-2 right-2 inline-flex items-center justify-center bg-white/20 text-white px-3 py-1 text-sm rounded-full">
                                {{ $ep->duration }} min
                            </span>
                        @endif
                    </div>
                    <div class="text-left">
                        <div class="flex flex-col space-y-1">
                            <p class="text-white text-lg font-semibold">
                                Ép {{ $ep->episode_number }} - {{ $ep->title }}
                            </p>
                        </div>
                        @if($ep->overview)
                            <p class="text-gray-300 text-base mt-2">{{ $ep->overview }}</p>
                        @endif
                        @if($ep->air_date)
                            <p class="text-gray-400 text-sm mt-1">Diffusé le {{ $ep->air_date->format('d M Y') }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-white">Aucun épisode disponible.</p>
            @endforelse
        </div>
    </section>
</body>
</html>
