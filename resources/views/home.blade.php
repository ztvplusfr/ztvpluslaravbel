<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZTV Plus - Accueil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

<script>
window.watchlistStatuses = @json($watchlistStatuses ?? []);

window.checkWatchlistStatus = function(id, type) {
    console.log('Checking watchlist status for:', { id, type });

    return fetch('{{ route('watchlist.status') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id: id, type: type })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Watchlist status data:', data);
        return data;
    })
    .catch(error => {
        console.error('Error checking watchlist status:', error);
        return Promise.resolve(null);
    });
};

window.updateWatchlistStatus = function(id, type, status) {
    let formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('id', id);
    formData.append('type', type);
    formData.append('status', status);

    fetch('{{ route('watchlist.update') }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        return data;
    })
    .catch(error => {
        console.error('Error:', error);
        throw error;
    });
};

window.showWatchlistOptions = function(button, id, type) {
    // Remove existing dropdown if any
    const existingDropdown = document.querySelector('.watchlist-dropdown');
    if (existingDropdown) {
        existingDropdown.remove();
    }

    const rect = button.getBoundingClientRect();
    const dropdown = document.createElement('div');
    dropdown.className = 'watchlist-dropdown absolute bg-gray-800 text-white rounded-lg shadow-lg py-2 mt-2 z-50 min-w-[200px]';
    dropdown.style.left = rect.left + 'px';
    dropdown.style.top = (rect.bottom + window.scrollY) + 'px';

    const options = [
        { status: 'to_watch', label: 'À voir', icon: '👁️' },
        { status: 'watching', label: 'En cours', icon: '▶️' },
        { status: 'watched', label: 'Terminé', icon: '✅' },
        { status: 'dropped', label: 'Abandonné', icon: '❌' }
    ];

    options.forEach(option => {
        const optionElement = document.createElement('button');
        optionElement.className = 'w-full text-left px-4 py-2 hover:bg-gray-700 flex items-center space-x-2';
        optionElement.innerHTML = `
            <span>${option.icon}</span>
            <span>${option.label}</span>
        `;

        optionElement.onclick = function() {
            window.updateWatchlistStatus(id, type, option.status)
                .then(data => {
                    dropdown.remove();
                    // Update button icon
                    updateWatchlistButton(button, data.in_watchlist, option.status);
                    showNotification(data.message);
                })
                .catch(error => {
                    showNotification('Erreur lors de la mise à jour', 'error');
                });
        };

        dropdown.appendChild(optionElement);
    });

    // Add remove option if item is in watchlist
    window.checkWatchlistStatus(id, type)
        .then(data => {
            if (data && data.in_watchlist) {
                const removeElement = document.createElement('button');
                removeElement.className = 'w-full text-left px-4 py-2 hover:bg-red-700 text-red-400 flex items-center space-x-2';
                removeElement.innerHTML = `
                    <span>🗑️</span>
                    <span>Retirer de la watchlist</span>
                `;

                removeElement.onclick = function() {
                    window.updateWatchlistStatus(id, type, 'remove')
                        .then(data => {
                            dropdown.remove();
                            updateWatchlistButton(button, false, null);
                            showNotification(data.message);
                        })
                        .catch(error => {
                            showNotification('Erreur lors du retrait', 'error');
                        });
                };

                dropdown.appendChild(removeElement);
            }
        });

    document.body.appendChild(dropdown);

    // Close dropdown when clicking outside
    setTimeout(() => {
        document.addEventListener('click', function closeDropdown(e) {
            if (!dropdown.contains(e.target) && !button.contains(e.target)) {
                dropdown.remove();
                document.removeEventListener('click', closeDropdown);
            }
        });
    }, 100);
};

window.updateWatchlistButton = function(button, inWatchlist, status) {
    const svg = button.querySelector('svg');
    const path = svg.querySelector('path');

    if (inWatchlist) {
        // Fill the heart icon with red
        svg.setAttribute('fill', '#ef4444');
        path.setAttribute('stroke-width', '0');
        path.setAttribute('d', 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z');

        // Add status indicator
        button.classList.add('bg-red-500/20');
        button.classList.remove('bg-white/20');
    } else {
        // Outline heart icon
        svg.setAttribute('fill', 'none');
        path.setAttribute('stroke', '#ffffff');
        path.setAttribute('stroke-width', '2');
        path.setAttribute('d', 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z');

        // Remove status indicator
        button.classList.add('bg-white/20');
        button.classList.remove('bg-red-500/20');
    }
};

window.showNotification = function(message, type = 'success') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(n => n.remove());

    const notification = document.createElement('div');
    notification.className = `notification fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
        type === 'error' ? 'bg-red-500' : 'bg-green-500'
    } text-white`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
};

// Initialize watchlist buttons on page load
document.addEventListener('DOMContentLoaded', function() {
    const watchlistButtons = document.querySelectorAll('button[data-id]');

    watchlistButtons.forEach(button => {
        const id = button.dataset.id;
        const type = button.dataset.type;

        console.log('Initializing watchlist button:', { id, type });

        // Use preloaded watchlist status
                const statusData = window.watchlistStatuses[id];
        if (statusData) {
            console.log('Watchlist status for', { id, type }, ':', statusData);
            updateWatchlistButton(button, statusData.in_watchlist, statusData.status);
        } else {
            // Fallback to default
            updateWatchlistButton(button, false, null);
        }

        // Add onclick handler
        button.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            const svg = button.querySelector('svg');
            const isInWatchlist = svg.getAttribute('fill') === '#ef4444';
            if (isInWatchlist) {
                // Optimistically update to removed
                updateWatchlistButton(button, false, null);
                // Then remove from watchlist
                window.updateWatchlistStatus(id, type, 'remove')
                    .then(data => {
                        window.watchlistStatuses[id] = { in_watchlist: false, status: null };
                        showNotification(data.message);
                    })
                    .catch(error => {
                        // Revert on error
                        updateWatchlistButton(button, true, 'to_watch');
                        showNotification('Erreur lors du retrait', 'error');
                    });
            } else {
                // Directly add to watchlist as 'to_watch'
                updateWatchlistButton(button, true, 'to_watch');
                window.updateWatchlistStatus(id, type, 'to_watch')
                    .then(data => {
                        window.watchlistStatuses[id] = { in_watchlist: true, status: 'to_watch' };
                        showNotification(data.message);
                    })
                    .catch(error => {
                        // Revert on error
                        updateWatchlistButton(button, false, null);
                        showNotification('Erreur lors de l\'ajout', 'error');
                    });
            }
        };
    });
});
    </script>
</head>
<body class="bg-background text-text">
    <x-navbar :currentRoute="request()->route()->getName()" />

    <div class="relative w-full bg-gray-900 overflow-hidden sm:h-[85vh] max-md:h-[70p paivh]">
            @if(isset($featuredItems) && $featuredItems->isNotEmpty())
            <!-- Slides -->
            <div class="slider-container flex flex-nowrap transition-transform duration-500 ease-in-out" id="slider">
                @foreach($featuredItems as $item)
                <div class="slide flex-shrink-0 w-full h-full relative max-md:h-[70vh]">
                    @if($item->backdrop_path)
                        <img src="https://image.tmdb.org/t/p/w1280{{ $item->backdrop_path }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                            <span class="text-white text-2xl">Image non disponible</span>
                        </div>
                    @endif
                    <!-- Desktop Info -->
                    <div class="hidden sm:flex absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent items-center justify-start pb-8 pl-20">
                        <div class="text-white max-w-md">
                            <h2 class="text-4xl font-bold mb-4">{{ $item->title }}</h2>
                            <p class="text-lg mb-6 line-clamp-3">{{ Str::limit($item->overview, 150) }}</p>
                            <div class="flex items-center space-x-1 mb-4 flex-nowrap overflow-x-auto">
                                <span class="bg-primary text-background px-2 py-1 rounded text-sm flex-shrink-0">{{ $item instanceof \App\Models\Movie ? 'Film' : 'Série' }}</span>
                                @if($item instanceof \App\Models\Movie && $item->duration)
                                    <span class="bg-white/20 backdrop-blur-sm text-white px-2 py-1 rounded text-sm flex-shrink-0">{{ floor($item->duration / 60) }}h {{ $item->duration % 60 }}m</span>
                                @endif
                                @if($item->genres && is_array($item->genres))
                                    @foreach(array_slice($item->genres, 0, 2) as $genre)
                                        <span class="bg-white/20 backdrop-blur-sm text-white px-2 py-1 rounded text-sm flex-shrink-0">{{ $genre }}</span>
                                    @endforeach
                                @endif
                                <span class="bg-white/20 backdrop-blur-sm text-white px-2 py-1 rounded text-sm flex-shrink-0">{{ $item->release_date ?? $item->first_air_date ? \Carbon\Carbon::parse($item->release_date ?? $item->first_air_date)->format('Y') : '' }}</span>
                                <div class="bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded flex items-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-sm">{{ number_format($item->vote_average, 1) }}</span>
                                </div>
                            </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ $item instanceof \App\Models\Movie ? route('movies.show', $item->id) : route('series.show', $item->id) }}" class="bg-primary text-background px-4 py-3 rounded-lg hover:bg-opacity-80 transition inline-flex items-center h-10">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                                Regarder
                            </a>
                            <button data-id="{{ $item->id }}" data-type="{{ $item instanceof \App\Models\Movie ? 'movie' : 'series' }}" class="bg-white/20 text-white hover:bg-white/30 px-4 py-3 rounded-lg transition inline-flex items-center justify-center h-10">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                        </div>
                    </div>
                    <!-- Mobile Info -->
                    <div class="sm:hidden absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent flex flex-col items-center justify-end pb-12 px-4 text-center">
                        <div class="text-white max-w-md mb-4">
                            <h2 class="text-2xl font-bold mb-2 text-center">{{ $item->title }}</h2>
                            <div class="flex items-center justify-center space-x-1 mb-4 flex-wrap">
                                <span class="bg-primary text-background px-2 py-1 rounded text-sm">{{ $item instanceof \App\Models\Movie ? 'Film' : 'Série' }}</span>
                                @if($item->genres && is_array($item->genres))
                                    @foreach(array_slice($item->genres, 0, 1) as $genre)
                                        <span class="bg-white/20 backdrop-blur-sm text-white px-2 py-1 rounded text-sm">{{ $genre }}</span>
                                    @endforeach
                                @endif
                                <span class="bg-white/20 backdrop-blur-sm text-white px-2 py-1 rounded text-sm">{{ $item->release_date ?? $item->first_air_date ? \Carbon\Carbon::parse($item->release_date ?? $item->first_air_date)->format('Y') : '' }}</span>
                            </div>
                            <p class="text-sm mb-6 line-clamp-3">{{ Str::limit($item->overview, 100) }}</p>
                        </div>
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ $item instanceof \App\Models\Movie ? route('movies.show', $item->id) : route('series.show', $item->id) }}" class="bg-primary text-background px-4 py-3 rounded-lg hover:bg-opacity-80 transition inline-flex items-center h-10">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                                Regarder
                            </a>
                            <button data-id="{{ $item->id }}" data-type="{{ $item instanceof \App\Models\Movie ? 'movie' : 'series' }}" class="bg-white/20 text-white hover:bg-white/30 px-4 py-3 rounded-lg transition inline-flex items-center justify-center h-10">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Navigation buttons -->
            <button class="hidden sm:block absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75" onclick="prevSlide()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button class="hidden sm:block absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75" onclick="nextSlide()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Dots -->
            <div class="absolute bottom-2 sm:bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                @for($i = 0; $i < $featuredItems->count(); $i++)
                <button class="w-2 h-2 sm:w-3 sm:h-3 rounded-full {{ $i === 0 ? 'bg-white' : 'bg-gray-400' }}" onclick="goToSlide({{ $i }})"></button>
                @endfor
            </div>
            @endif
        </div>

    <!-- Section Derniers films sortis -->
    <section class="py-8 w-full px-0 sm:px-6 lg:px-0 lg:pl-12 mx-0">
        <h2 class="text-white text-2xl font-bold mb-6">Derniers films sortis</h2>
        <div>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8 place-items-stretch gap-4 pb-4 min-h-[11rem]">
                @if(isset($latestMovies) && $latestMovies->isNotEmpty())
                    @foreach($latestMovies as $movie)
                    <a href="{{ route('movies.show', $movie->id) }}" class="relative group block h-52 sm:h-56 lg:h-[calc(100vw/8*1.5)] aspect-[2/3]">
                        @if($movie->poster_path)
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}" alt="{{ $movie->title }}" class="w-full h-full object-cover object-center aspect-[2/3]">
                        @else
                            <div class="w-full h-full bg-gray-800 flex items-center justify-center aspect-[2/3]">
                                <span class="text-white text-sm">Image non disponible</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-white text-sm mt-2 font-medium text-center">{{ $movie->title }}</h3>
                    </a>
                    @endforeach
                    @for($i = $latestMovies->count(); $i < 8; $i++)
                        <div></div>
                    @endfor
                @else
                    <p class="text-white">Aucun film récent disponible.</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Section Dernières séries sorties -->
    <section class="py-8 w-full px-0 sm:px-6 lg:px-0 lg:pl-12 mx-0">
        <h2 class="text-white text-2xl font-bold mb-6">Dernières séries sorties</h2>
        <div>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8 place-items-stretch gap-4 pb-4 min-h-[11rem]">
                @if(isset($latestSeries) && $latestSeries->isNotEmpty())
                    @foreach($latestSeries as $serie)
                    <a href="{{ route('series.show', $serie->id) }}" class="relative group block h-72 sm:h-56 lg:h-[calc(100vw/8*1.5)] aspect-[2/3]">
                        @if($serie->poster_path)
                            <img src="https://image.tmdb.org/t/p/w500{{ $serie->poster_path }}" alt="{{ $serie->title }}" class="w-full h-full object-cover object-center aspect-[2/3]">
                        @else
                            <div class="w-full h-full bg-gray-800 flex items-center justify-center aspect-[2/3]">
                                <span class="text-white text-sm">Image non disponible</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-white text-sm mt-2 font-medium text-center">{{ $serie->title }}</h3>
                    </a>
                    @endforeach
                    @for($i = $latestSeries->count(); $i < 8; $i++)
                        <div></div>
                    @endfor
                @else
                    <p class="text-white">Aucune série récente disponible.</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Section Chaînes -->
    <section class="py-8 w-full px-0 sm:px-6 lg:px-0 lg:pl-12 mx-0">
        <h2 class="text-white text-2xl font-bold mb-6">Chaînes</h2>
        <div class="overflow-x-auto">
            <div class="flex space-x-4 pb-4">
                @if(isset($networks) && $networks->isNotEmpty())
                    @foreach($networks as $network)
                    <a href="{{ route('networks.show', $network->id) }}" class="flex-shrink-0 w-64 relative group block">
                        @if($network->logo)
                            @php
                                $logoUrl = preg_match('/^https?:\/\//', $network->logo)
                                    ? $network->logo
                                    : asset('storage/' . $network->logo);
                            @endphp
                            <img src="{{ $logoUrl }}" alt="{{ $network->name }}" class="w-full h-40 object-contain object-center">
                        @else
                            <div class="w-full h-40 bg-gray-800 flex items-center justify-center">
                                <span class="text-white text-sm">Logo non disponible</span>
                            </div>
                        @endif
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-white text-sm mt-2 font-medium text-center">{{ $network->name }}</h3>
                    </a>
                    @endforeach
                @else
                    <p class="text-white">Aucune chaîne disponible.</p>
                @endif
            </div>
        </div>
    </section>

    <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.absolute.bottom-2 button, .absolute.bottom-4 button');
    const slider = document.getElementById('slider');
    let isDragging = false;
    let startX = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let animationID;

    function showSlide(index) {
        currentSlide = index;
        currentTranslate = -index * slider.offsetWidth;
        prevTranslate = currentTranslate;
        slider.style.transform = `translateX(${currentTranslate}px)`;
        dots.forEach((dot, i) => {
            dot.classList.remove('bg-white', 'bg-gray-400');
            if (i === index) {
                dot.classList.add('bg-white');
            } else {
                dot.classList.add('bg-gray-400');
            }
        });
    }

    function setPositionByIndex() {
        currentTranslate = -currentSlide * slider.offsetWidth;
        prevTranslate = currentTranslate;
        slider.style.transition = 'transform 0.3s ease-out';
        slider.style.transform = `translateX(${currentTranslate}px)`;
    }

    function touchStart(index) {
        return function (event) {
            isDragging = true;
            startX = event.touches[0].clientX;
            slider.style.transition = 'none';
            animationID = requestAnimationFrame(animation);
        };
    }

    function touchMove(event) {
        if (isDragging) {
            const currentX = event.touches[0].clientX;
            currentTranslate = prevTranslate + currentX - startX;
        }
    }

    function touchEnd() {
        cancelAnimationFrame(animationID);
        isDragging = false;
        const movedBy = currentTranslate - prevTranslate;

        if (movedBy < -50 && currentSlide < slides.length - 1) {
            currentSlide += 1;
        }

        if (movedBy > 50 && currentSlide > 0) {
            currentSlide -= 1;
        }

        setPositionByIndex();
        showSlide(currentSlide);
    }

    function animation() {
        slider.style.transform = `translateX(${currentTranslate}px)`;
        if (isDragging) requestAnimationFrame(animation);
    }

    // Ajout des fonctions pour les boutons de navigation
    function prevSlide() {
        if (currentSlide > 0) {
            currentSlide -= 1;
            setPositionByIndex();
            showSlide(currentSlide);
        }
    }

    function nextSlide() {
        if (currentSlide < slides.length - 1) {
            currentSlide += 1;
            setPositionByIndex();
            showSlide(currentSlide);
        }
    }

    // Initialize
    if (slides.length > 0) {
        showSlide(0);
        slides.forEach((slide, index) => {
            const slideImage = slide.querySelector('img');
            slideImage.addEventListener('dragstart', (e) => e.preventDefault());

            // Touch events
            slide.addEventListener('touchstart', touchStart(index));
            slide.addEventListener('touchmove', touchMove);
            slide.addEventListener('touchend', touchEnd);
        });
    }

    // Auto slide
    setInterval(() => {
        if (!isDragging) {
            currentSlide = (currentSlide + 1) % slides.length;
            setPositionByIndex();
            showSlide(currentSlide);
        }
    }, 5000);
    </script>

    <x-bottom-nav :currentRoute="request()->route()->getName()" />
</body>
</html>
