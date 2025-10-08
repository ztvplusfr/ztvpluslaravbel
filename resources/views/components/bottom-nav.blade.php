@props(['currentRoute' => null])

<nav class="fixed bottom-0 left-0 right-0 z-50 block sm:hidden bg-gray-800/80 backdrop-blur-md border-t border-gray-700 rounded-t-3xl px-6 py-4 shadow-lg">
    <div class="flex justify-around items-center">
        <!-- Home -->
        <a href="{{ route('home') }}"
           class="flex flex-col items-center space-y-1 p-2 rounded-lg transition-all duration-200 {{ $currentRoute === 'home' ? 'text-primary bg-primary/20' : 'text-gray-400 hover:text-white hover:bg-gray-700/50' }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs font-medium">Accueil</span>
        </a>

        <!-- Movies -->
        <a href="{{ route('movies.index') }}"
           class="flex flex-col items-center space-y-1 p-2 rounded-lg transition-all duration-200 {{ $currentRoute === 'movies.index' ? 'text-primary bg-primary/20' : 'text-gray-400 hover:text-white hover:bg-gray-700/50' }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
            <span class="text-xs font-medium">Films</span>
        </a>

        <!-- TV Series -->
        <a href="{{ route('series.index') }}"
           class="flex flex-col items-center space-y-1 p-2 rounded-lg transition-all duration-200 {{ $currentRoute === 'series.index' ? 'text-primary bg-primary/20' : 'text-gray-400 hover:text-white hover:bg-gray-700/50' }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                <path d="M16 3l-4 4l-4 -4" />
            </svg>
            <span class="text-xs font-medium">Séries</span>
        </a>

        <!-- Watchlist -->
        <a href="{{ route('watchlist.index') }}"
           class="flex flex-col items-center space-y-1 p-2 rounded-lg transition-all duration-200 {{ $currentRoute === 'watchlist.index' ? 'text-primary bg-primary/20' : 'text-gray-400 hover:text-white hover:bg-gray-700/50' }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <span class="text-xs font-medium">Ma Liste</span>
        </a>
    </div>
</nav>
