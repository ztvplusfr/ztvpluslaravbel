@props(['currentRoute' => null])

<header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <div class="w-full px-6">
        <div class="flex justify-between items-center h-16">
            <!-- Logo à gauche -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('brand/logo.png') }}" alt="Logo" class="h-8 w-auto">
                </a>
            </div>

            <!-- Liens au centre -->
            <nav class="hidden sm:flex space-x-8 group">
                <a href="{{ route('home') }}"
                   class="relative text-gray-400 pb-1 transition-colors transition-all duration-200 ease-in-out 
                          hover:text-text hover:border-b-2 hover:border-cyan-400 
                          {{ $currentRoute === 'home' ? 'text-text border-b-2 border-cyan-400 group-hover:border-transparent' : '' }}">
                    Home
                </a>
                <a href="{{ route('movies.index') }}"
                   class="relative text-gray-400 pb-1 transition-colors transition-all duration-200 ease-in-out 
                          hover:text-text hover:border-b-2 hover:border-cyan-400 
                          {{ $currentRoute === 'movies.index' ? 'text-text border-b-2 border-cyan-400 group-hover:border-transparent' : '' }}">
                    Movies
                </a>
                <a href="{{ route('series.index') }}"
                   class="relative text-gray-400 pb-1 transition-colors transition-all duration-200 ease-in-out 
                          hover:text-text hover:border-b-2 hover:border-cyan-400 
                          {{ $currentRoute === 'series.index' ? 'text-text border-b-2 border-cyan-400 group-hover:border-transparent' : '' }}">
                    Series
                </a>
                <a href="{{ route('animes.index') }}"
                   class="relative text-gray-400 pb-1 transition-colors transition-all duration-200 ease-in-out 
                          hover:text-text hover:border-b-2 hover:border-cyan-400 
                          {{ $currentRoute === 'animes.index' ? 'text-text border-b-2 border-cyan-400 group-hover:border-transparent' : '' }}">
                    Animes
                </a>
            </nav>

            <!-- Boutons à droite -->
            <div class="flex items-center space-x-4">
                <div class="hidden sm:flex items-center space-x-4">
                    <!-- Icone Search navigue vers la page de recherche -->
                    <a href="{{ route('movies.search') }}" class="relative pb-1 p-2 rounded-full transition-colors {{ $currentRoute === 'movies.search' ? 'text-primary bg-gray-800' : 'text-text hover:text-primary hover:bg-gray-800' }}">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>

                    <!-- Bouton Watchlist -->
                    <a href="{{ route('watchlist.index') }}" class="relative pb-1 p-2 rounded-full transition-colors {{ $currentRoute === 'watchlist.index' ? 'text-primary bg-gray-800' : 'text-text hover:text-primary hover:bg-gray-800' }}">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </a>
                </div>

                <!-- Bouton Avatar / Utilisateur -->
                @if(Auth::check() && Auth::user()->avatar)
                    <div class="relative group flex items-center">
                        <div class="flex items-center cursor-pointer group/avatar">
                            <a href="{{ route('account') }}" class="flex items-center p-2">
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="h-6 w-6 rounded-full" />
                                <span class="ml-2 text-white font-bold uppercase sm:inline-block hidden">{{ Auth::user()->name }}</span>
                            </a>
                        </div>
                        <div class="hidden sm:block absolute left-0 top-0 w-[calc(100%+16px)] h-full rounded-lg bg-black/60 backdrop-blur-md {{ $currentRoute === 'account' ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition-opacity duration-200 z-[-1]" style="margin-right:-16px;"></div>
                    </div>
                @elseif(Auth::check())
                    <div class="relative group flex items-center">
                        <div class="flex items-center cursor-pointer group/avatar">
                            <a href="{{ route('account') }}" class="flex items-center p-2">
                                <div class="h-6 w-6 rounded-full bg-gray-500 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                </div>
                                <span class="ml-2 text-white font-bold uppercase sm:inline-block hidden">{{ Auth::user()->name }}</span>
                            </a>
                        </div>
                        <div class="hidden sm:block absolute left-0 top-0 w-[calc(100%+16px)] h-full rounded-lg bg-black/60 backdrop-blur-md {{ $currentRoute === 'account' ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition-opacity duration-200 z-[-1]" style="margin-right:-16px;"></div>
                    </div>
                @else
                    <button class="text-text hover:text-primary transition-colors p-2 rounded-full hover:bg-gray-800">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('navbar');
    
    function updateNavbar() {
        if (window.scrollY > 50) {
            navbar.classList.add('bg-black', 'shadow-lg');
        } else {
            navbar.classList.remove('bg-black', 'shadow-lg');
        }
    }
    
    window.addEventListener('scroll', updateNavbar);
    updateNavbar(); // Check initial state
});
</script>
