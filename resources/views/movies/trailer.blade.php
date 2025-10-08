<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bande-annonce - {{ $movie->title }} – ZTV Plus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://www.youtube.com/iframe_api"></script>
    <style>
        :root{--ctrl-bg:rgba(0,0,0,.6);--ctrl-fg:#fff;--accent:#fff}
        html,body{height:100%;margin:0}
        body{background:#000;color:#fff;overflow:hidden;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial}
        #player-wrapper{
            position:fixed;
            inset:0;
            background:#000;
            display:flex;
            height:100%;
            width:100%;
            overflow:hidden;
        }
        #yt-player{
            flex:1 1 0%;
            position:relative;
            width:100%;
            height:100%;
            border:none;
        }
        #yt-player iframe {width:100%;height:100%;border:none}
        #movie-info {
            width:340px;
            min-width:260px;
            max-width:340px;
            background:linear-gradient(to top,rgba(0,0,0,0.95) 80%,rgba(0,0,0,0.7) 100%);
            box-shadow:-2px 0 16px 0 rgba(0,0,0,0.3);
            padding:0 1.5rem 1.5rem 1.5rem;
            color:#fff;
            display:flex;
            flex-direction:column;
            justify-content:flex-start;
            align-items:flex-start;
            position:relative;
            z-index:20;
        }
        @media (max-width:900px){#movie-info{width:220px;min-width:180px;padding:1rem}}
        @media (max-width:640px){#movie-info{display:none}}
        #yt-player{position:relative;width:100%;height:100%;border:none}
        #yt-player iframe {width:100%;height:100%;border:none}
        /* small responsive tweaks */
        @media (max-width:640px){.title{font-size:14px}.time{min-width:70px}.volume{display:none}}
    /* Removed custom back-btn styling: replaced by Tailwind classes */

        /* Style for the movie info section */
        /*#movie-info {
            padding: 20px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        #movie-info .title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        #movie-info .details {
            font-size: 16px;
            opacity: 0.8;
        }*/
    </style>
</head>
<body class="bg-black text-white">
    <div id="player-wrapper">
        <!-- Bouton Retour en overlay -->
        <button class="absolute top-4 left-4 z-50 bg-primary text-background rounded-full w-10 h-10 flex items-center justify-center hover:bg-primary/80 transition" onclick="history.back()" title="Retour">←</button>
        <div id="yt-player">
            <iframe 
                id="player" 
                src="https://www.youtube-nocookie.com/embed/{{ $movie->trailer_id }}?autoplay=1&mute=0&rel=0&showinfo=0&controls=1"
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        </div>

        <div id="movie-info">
            <!-- Backdrop cliquable -->
            <a href="{{ route('movies.show', $movie->id) }}" 
               class="group block h-40 bg-cover bg-center mb-12 border-b-2 border-transparent hover:border-cyan-400 transition"
               style="background-image: url('https://image.tmdb.org/t/p/original{{ $movie->backdrop_path }}'); margin-left: -1.5rem; margin-right: -1.5rem; width: calc(100% + 3rem);"
               title="Voir la fiche du film">
            </a>
            <h1 class="text-xl md:text-2xl font-bold uppercase text-white mb-3 leading-tight line-clamp-2 max-w-xs">
                <a href="{{ route('movies.show', $movie->id) }}" class="hover:text-cyan-400 transition">{{ $movie->title }}</a>
            </h1>
            <div class="flex flex-wrap items-center gap-2 text-xs text-white mb-4">
                @if($movie->duration)
                    <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1 rounded-full space-x-1 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ floor($movie->duration/60) }}h {{ $movie->duration % 60 }}m</span>
                    </span>
                @endif
                @if($movie->release_date)
                    <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1 rounded-full space-x-1 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}</span>
                    </span>
                @endif
                <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1 rounded-full space-x-1 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    <span>{{ number_format($movie->vote_average,1) }}</span>
                </span>
                @if($movie->age_rating)
                    <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1 rounded-full space-x-1 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span>{{ $movie->age_rating }}</span>
                    </span>
                @endif
                @if(!empty($movie->genres))
                    @foreach($movie->genres as $genre)
                        <span class="inline-flex items-center justify-center bg-white/20 text-white px-3 py-1 rounded-full space-x-1 font-semibold">
                            {{ $genre }}
                        </span>
                    @endforeach
                @endif
            </div>
            <p class="text-white mt-6 text-sm leading-relaxed max-w-xs opacity-80">
                {{ $movie->overview }}
            </p>
        </div>
        </div>
    </div>

    {{-- Custom player with YouTube JS API and custom controls --}}
    
</body>
</html>