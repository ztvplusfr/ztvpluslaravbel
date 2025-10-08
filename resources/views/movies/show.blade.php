<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $movie->title }} – ZTV Plus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text min-h-screen">
    <x-navbar currentRoute="movies.show" />

    {{-- Hero section mobile --}}
    <div class="block md:hidden">
        <div class="relative w-full h-[100vh] mb-8 bg-cover bg-center" style="background-image: url('https://image.tmdb.org/t/p/original{{ $movie->backdrop_path }}')">
            <div class="absolute inset-0 bg-black/50"></div>
            <!-- Overlay gradient bas pour effet Netflix -->
            <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-black to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end h-full pl-1 absolute bottom-0 w-full">
                <h1
                  class="text-2xl font-bold uppercase text-white mb-4 leading-tight line-clamp-2 max-w-full text-left">
                  {{ $movie->title }}
                </h1>
                <div class="flex flex-wrap gap-2 text-xs text-white mb-6">
                    @if($movie->duration)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1.5 rounded-full space-x-1 text-sm font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ floor($movie->duration/60) }}h {{ $movie->duration % 60 }}m</span>
                        </span>
                    @endif
                    @if($movie->release_date)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1.5 rounded-full space-x-1 text-sm font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</span>
                        </span>
                    @endif
                    <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1.5 rounded-full space-x-1 text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <span>{{ number_format($movie->vote_average,1) }}</span>
                    </span>
                    @if($movie->age_rating)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1.5 rounded-full space-x-1 text-sm font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <span>{{ $movie->age_rating }}</span>
                        </span>
                    @endif
                    @if(!empty($movie->genres))
            @foreach($movie->genres as $genre)
                <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1.5 rounded-full space-x-1 text-sm font-semibold">
                                {{ $genre }}
                            </span>
                        @endforeach
                    @endif
                </div>
                         <div class="flex flex-col space-y-2">
                            <a href="{{ $movie->videos->isNotEmpty() ? route('movie.play', $movie->id) : '#' }}"
                                class="{{ $movie->videos->isNotEmpty() ? 'bg-primary text-background hover:bg-opacity-80' : 'bg-gray-500 text-gray-300 cursor-not-allowed opacity-50' }} inline-flex w-full items-center justify-center px-6 py-3 text-lg font-semibold rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.5 5.5l7 4.5-7 4.5v-9z" />
                        </svg>
                        Regarder
                    </a>
                        <a href="{{ $movie->trailer_id ? route('movie.trailer', $movie->id) : '#' }}"
                           class="{{ $movie->trailer_id ? 'bg-transparent border border-white/50 text-white hover:bg-white/10' : 'bg-gray-500 text-gray-300 border border-gray-500 cursor-not-allowed opacity-50' }} inline-flex w-full items-center justify-center px-6 py-3 text-lg font-semibold rounded-full transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-movie mr-2">
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
                            Bande annonce
                        </a>
                </div>

                {{-- Overview --}}
                <p class="text-white mt-12 max-w-2xl text-lg leading-relaxed line-clamp-3">
                    {{ $movie->overview }}
                </p>
            </div>
        </div>
    </div>

    {{-- Hero section desktop --}}
    <div class="hidden md:block">
        <div class="relative w-full h-[100vh] mb-8 bg-cover bg-center" style="background-image: url('https://image.tmdb.org/t/p/original{{ $movie->backdrop_path }}')">
            <div class="absolute inset-0 bg-black/50"></div>
            <!-- Overlay gradient bas pour effet Netflix -->
            <div class="absolute inset-x-0 bottom-0 h-3/4 bg-gradient-to-t from-black to-transparent"></div>
            <div class="relative z-10 flex flex-col justify-end h-full p-8 absolute bottom-0 w-full">
                <h1
                  class="text-4xl md:text-5xl font-bold uppercase text-white mb-4 leading-tight line-clamp-2 max-w-2xl">
                  {{ $movie->title }}
                </h1>
                <div class="flex items-center space-x-4 text-sm text-white mb-6">
                    @if($movie->duration)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-4 py-2 rounded-full space-x-2 text-base font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ floor($movie->duration/60) }}h {{ $movie->duration % 60 }}m</span>
                        </span>
                    @endif
                    @if($movie->release_date)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-4 py-2 rounded-full space-x-2 text-base font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</span>
                        </span>
                    @endif
                    <span class="inline-flex items-center justify-center bg-white/20 text-white px-4 py-2 rounded-full space-x-2 text-base font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <span>{{ number_format($movie->vote_average,1) }}</span>
                    </span>
                    @if($movie->age_rating)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-4 py-2 rounded-full space-x-2 text-base font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <span>{{ $movie->age_rating }}</span>
                        </span>
                    @endif
                    @if(!empty($movie->genres))
            @foreach($movie->genres as $genre)
                <span class="inline-flex items-center justify-center bg-white/20 text-white px-4 py-2 rounded-full space-x-2 text-base font-semibold">
                                {{ $genre }}
                            </span>
                        @endforeach
                    @endif
                </div>
                         <div class="flex items-center space-x-2">
                            <a href="{{ $movie->videos->isNotEmpty() ? route('movie.play', $movie->id) : '#' }}"
                                class="{{ $movie->videos->isNotEmpty() ? 'bg-primary text-background hover:bg-opacity-80' : 'bg-gray-500 text-gray-300 cursor-not-allowed opacity-50' }} inline-flex w-64 items-center justify-center px-6 py-3 text-lg font-semibold rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.5 5.5l7 4.5-7 4.5v-9z" />
                        </svg>
                        Regarder
                    </a>
                        <a href="{{ $movie->trailer_id ? route('movie.trailer', $movie->id) : '#' }}"
                           class="{{ $movie->trailer_id ? 'bg-transparent border border-white/50 text-white hover:bg-white/10' : 'bg-gray-500 text-gray-300 border border-gray-500 cursor-not-allowed opacity-50' }} inline-flex items-center justify-center px-6 py-3 text-lg font-semibold rounded-full">
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
                            <span class="ml-2">Bande annonce</span>
                        </a>
                </div>

                {{-- Overview --}}
                <p class="text-white mt-12 max-w-2xl text-lg leading-relaxed">
                    {{ $movie->overview }}
                </p>
            </div>
        </div>
    </div>


</body>
</html>
