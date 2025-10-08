<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lecture - {{ $episode->title }} – ZTV Plus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white">
    {{-- Mobile Version --}}
    <div class="block md:hidden">
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
    <div id="player-wrapper-mobile" class="min-h-screen bg-black text-white flex flex-col" style="background-image: url('https://image.tmdb.org/t/p/original{{ $episode->season->series->backdrop_path }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <!-- Bouton Retour -->
        <div id="back-button" class="absolute top-4 left-4 z-50">
            <button class="bg-primary text-background rounded-full w-10 h-10 flex items-center justify-center hover:bg-primary/80 transition" onclick="history.back()" title="Retour">←</button>
        </div>
        <!-- Video Embed -->
        <div class="h-96 md:h-full relative">
            @if($video)
                <iframe src="{{ $video->embed_link }}" 
                        class="w-full h-full"
                        frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                </iframe>
                <!-- Overlay for mouse detection -->
                <div id="video-overlay" class="absolute inset-0 pointer-events-none"></div>
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-900">
                    <div class="text-center text-white">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        <h2 class="text-2xl font-bold mb-2">Aucune vidéo disponible</h2>
                        <p class="text-gray-400">Ce contenu n'est pas encore disponible pour lecture.</p>
                    </div>
                </div>
            @endif
        </div>
        <!-- Infos section -->
        <div class="bg-black/90 p-4">
            <!-- Boutons de navigation -->
            <div class="flex justify-center space-x-4 mb-4">
                <div class="flex-1 flex items-center justify-start">
                    @if($prevEpisode)
                        <a href="{{ route('series.play', ['series_id' => $episode->season->series->id, 'season_number' => $episode->season->season_number, 'episode_number' => $prevEpisode->episode_number]) }}" class="bg-gray-600 text-white rounded-full px-4 py-3 flex items-center justify-center hover:bg-gray-500 transition text-sm font-semibold w-full max-w-xs">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Précédent
                        </a>
                    @else
                        <button class="bg-gray-800 text-gray-500 rounded-full px-4 py-3 flex items-center justify-center cursor-not-allowed text-sm font-semibold w-full max-w-xs" disabled title="Aucun épisode précédent">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Précédent
                        </button>
                    @endif
                </div>
                <div class="flex-1 flex items-center justify-end">
                    @if($nextEpisode)
                        <a href="{{ route('series.play', ['series_id' => $episode->season->series->id, 'season_number' => $episode->season->season_number, 'episode_number' => $nextEpisode->episode_number]) }}" class="bg-gray-600 text-white rounded-full px-4 py-3 flex items-center justify-center hover:bg-gray-500 transition text-sm font-semibold w-full max-w-xs">
                            Suivant
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <button class="bg-gray-800 text-gray-500 rounded-full px-4 py-3 flex items-center justify-center cursor-not-allowed text-sm font-semibold w-full max-w-xs" disabled title="Aucun épisode suivant">
                            Suivant
                            <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
            <h1 class="text-xl text-center font-bold uppercase hover:text-primary transition mb-2">
                <a href="{{ route('series.show', $episode->season->series->id) }}">{{ $episode->season->series->title }}</a>
            </h1>
            <h2 class="text-lg font-semibold text-center mb-2">{{ $episode->title }}</h2>
            <div class="flex flex-wrap justify-center items-center gap-2 text-xs mb-4">
                <span class="bg-white/20 px-2 py-1 rounded-full">S{{ $episode->season->season_number }}E{{ $episode->episode_number }}</span>
                @if($episode->duration)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ $episode->duration }} min</span>
                @endif
                @if($episode->air_date)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ \Carbon\Carbon::parse($episode->air_date)->format('d/m/Y') }}</span>
                @endif
            </div>
            <p class="text-sm leading-relaxed opacity-80 text-center">{{ $episode->overview }}</p>
            @if($nextEpisode)
                <p class="text-sm text-primary mt-2 text-center">Épisode suivant: S{{ $episode->season->season_number }}E{{ $nextEpisode->episode_number }} - {{ $nextEpisode->title }}</p>
            @endif
            @if($videos->isNotEmpty())
                <p class="text-xl font-bold text-white mb-2 text-center mt-4">Source</p>
                <!-- Sélecteur de source (dropdown) en bas -->
                <div class="mt-4 flex justify-center">
                    <select onchange="window.location.href=this.value" class="w-full max-w-sm bg-black/90 border border-white/40 text-white rounded-full px-4 py-2 focus:outline-none focus:border-primary">
                        @foreach($videos as $src)
                            <option value="{{ route('series.play', ['series_id' => $episode->season->series->id, 'season_number' => $episode->season->season_number, 'episode_number' => $episode->episode_number, 'video' => $src->id]) }}" {{ $video && $video->id == $src->id ? 'selected' : '' }}>
                                {{ $src->server_name ?? 'Source ' . ($loop->index + 1) }} · {{ $langMap[strtolower($src->language)] ?? $src->language }} · {{ $src->quality }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <p class="text-xl font-bold text-white mb-2 text-center mt-4">Source</p>
                <div class="mt-4 text-center">
                    <p class="text-gray-400">Aucune source disponible</p>
                </div>
            @endif
        </div>
        @if($nextEpisodes->isNotEmpty())
            <div class="bg-black/90 p-4">
                <p class="text-xl font-bold text-white mb-2 text-center">Épisodes suivants - Saison {{ $episode->season->season_number }}</p>
                <div class="space-y-2">
                    @foreach($nextEpisodes as $ep)
                        <a href="{{ route('series.play', ['series_id' => $ep->season->series->id, 'season_number' => $ep->season->season_number, 'episode_number' => $ep->episode_number]) }}" class="flex items-center space-x-3 hover:bg-white/10 p-3 rounded transition">
                            @if($ep->still_path)
                                <img src="https://image.tmdb.org/t/p/w300{{ $ep->still_path }}" alt="{{ $ep->title }}" class="w-20 h-12 object-cover rounded">
                            @endif
                            <div>
                                <span class="font-semibold text-base">E{{ $ep->episode_number }}</span>
                                <p class="text-sm text-gray-300">{{ $ep->title }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
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
    <div id="player-wrapper" class="fixed inset-0 bg-black flex" style="background-image: url('https://image.tmdb.org/t/p/original{{ $episode->season->series->backdrop_path }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <!-- Bouton Retour -->
        <div id="back-button" class="absolute top-4 left-4 z-50">
            <button class="bg-primary text-background rounded-full w-10 h-10 flex items-center justify-center hover:bg-primary/80 transition" onclick="history.back()" title="Retour">←</button>
        </div>
        <!-- Video Embed -->
        <div class="flex-1 relative">
            @if($video)
                <iframe src="{{ $video->embed_link }}"
                        class="w-full h-full"
                        frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                </iframe>
                <!-- Overlay for mouse detection -->
                <div id="video-overlay" class="absolute inset-0 pointer-events-none"></div>
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-900">
                    <div class="text-center text-white">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        <h2 class="text-2xl font-bold mb-2">Aucune vidéo disponible</h2>
                        <p class="text-gray-400">Ce contenu n'est pas encore disponible pour lecture.</p>
                    </div>
                </div>
            @endif
            <!-- Boutons de navigation -->
            <div id="top-controls" class="absolute top-4 right-4 flex space-x-2 z-50">
                @if($prevEpisode)
                    <a href="{{ route('series.play', ['series_id' => $episode->season->series->id, 'season_number' => $episode->season->season_number, 'episode_number' => $prevEpisode->episode_number]) }}" class="bg-gray-600 text-white rounded-full px-4 py-2 flex items-center justify-center hover:bg-gray-500 transition text-sm font-semibold" title="Épisode précédent">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Précédent
                    </a>
                @else
                    <button class="bg-gray-800 text-gray-500 rounded-full px-4 py-2 flex items-center justify-center cursor-not-allowed text-sm font-semibold" disabled title="Aucun épisode précédent">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Précédent
                    </button>
                @endif

                @if($nextEpisode)
                    <a href="{{ route('series.play', ['series_id' => $episode->season->series->id, 'season_number' => $episode->season->season_number, 'episode_number' => $nextEpisode->episode_number]) }}" class="bg-gray-600 text-white rounded-full px-4 py-2 flex items-center justify-center hover:bg-gray-500 transition text-sm font-semibold" title="Épisode suivant">
                        Suivant
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <button class="bg-gray-800 text-gray-500 rounded-full px-4 py-2 flex items-center justify-center cursor-not-allowed text-sm font-semibold" disabled title="Aucun épisode suivant">
                        Suivant
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                @endif
                <!-- Bouton Plein écran -->
                <button onclick="toggleFullscreen()" class="bg-gray-600 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-gray-500 transition" title="Plein écran">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-maximize"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /></svg>
                </button>
                <!-- Bouton Masquer panneau -->
                <button id="toggle-panel" onclick="togglePanel()" class="bg-gray-600 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-gray-500 transition" title="Masquer panneau">
                    <svg id="panel-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-compact-left">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M13 20l-3 -8l3 -8" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Infos section -->
        <div id="episode-info-desktop" class="w-80 bg-black/80 p-4 flex flex-col space-y-4 overflow-auto h-full">
            <h1 class="text-xl font-bold uppercase hover:text-primary transition">
                <a href="{{ route('series.show', $episode->season->series->id) }}">{{ $episode->season->series->title }}</a>
            </h1>
            <h2 class="text-lg font-semibold">{{ $episode->title }}</h2>
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="bg-white/20 px-2 py-1 rounded-full">S{{ $episode->season->season_number }}E{{ $episode->episode_number }}</span>
                @if($episode->duration)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ $episode->duration }} min</span>
                @endif
                @if($episode->air_date)
                    <span class="bg-white/20 px-2 py-1 rounded-full">{{ \Carbon\Carbon::parse($episode->air_date)->format('d/m/Y') }}</span>
                @endif
            </div>
            <p class="text-sm leading-relaxed opacity-80">{{ $episode->overview }}</p>
            @if($nextEpisode)
                <p class="text-sm text-primary mt-2">Épisode suivant: S{{ $episode->season->season_number }}E{{ $nextEpisode->episode_number }} - {{ $nextEpisode->title }}</p>
            @endif
            @if($videos->isNotEmpty())
                <p class="text-xl font-bold text-white mb-2">Source</p>
                <!-- Sélecteur de source (dropdown) en bas -->
                <div class="mt-4">
                    <select onchange="window.location.href=this.value" class="w-full bg-black/90 border border-white/40 text-white rounded-full px-4 py-2 focus:outline-none focus:border-primary">
                        @foreach($videos as $src)
                            <option value="{{ route('series.play', ['series_id' => $episode->season->series->id, 'season_number' => $episode->season->season_number, 'episode_number' => $episode->episode_number, 'video' => $src->id]) }}" {{ $video && $video->id == $src->id ? 'selected' : '' }}>
                                {{ $src->server_name ?? 'Source ' . ($loop->index + 1) }} · {{ $langMap[strtolower($src->language)] ?? $src->language }} · {{ $src->quality }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <p class="text-xl font-bold text-white mb-2">Source</p>
                <div class="mt-4">
                    <p class="text-gray-400">Aucune source disponible</p>
                </div>
            @endif
            @if($nextEpisodes->isNotEmpty())
                <p class="text-xl font-bold text-white mb-2 mt-4">Épisodes suivants - Saison {{ $episode->season->season_number }}</p>
                <div class="flex-1 min-h-0 overflow-y-auto space-y-2">
                    @foreach($nextEpisodes as $ep)
                        <a href="{{ route('series.play', ['series_id' => $ep->season->series->id, 'season_number' => $ep->season->season_number, 'episode_number' => $ep->episode_number]) }}" class="flex items-center space-x-3 hover:bg-white/10 p-3 rounded transition">
                            @if($ep->still_path)
                                <img src="https://image.tmdb.org/t/p/w300{{ $ep->still_path }}" alt="{{ $ep->title }}" class="w-20 h-12 object-cover rounded">
                            @endif
                            <div>
                                <span class="font-semibold text-base">E{{ $ep->episode_number }}</span>
                                <p class="text-sm text-gray-300">{{ $ep->title }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update content without reload
    function loadEpisode(url) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const newDoc = parser.parseFromString(html, 'text/html');
                const newWrapper = newDoc.getElementById('player-wrapper');
                const currentWrapper = document.getElementById('player-wrapper');
                currentWrapper.innerHTML = newWrapper.innerHTML;
                // Update URL without reload
                history.pushState(null, '', url);
                // Re-attach event listeners to new elements
                attachEventListeners();
            })
            .catch(error => {
                console.error('Error loading episode:', error);
                // Fallback to normal navigation
                window.location.href = url;
            });
    }

    // Toggle panel function
    window.togglePanel = function() {
        const panel = document.getElementById('episode-info') || document.getElementById('episode-info-desktop');
        const icon = document.getElementById('panel-icon');
        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            // Change to close icon (chevron right)
            if (icon) {
                icon.innerHTML = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 4l3 8l-3 8" />';
                document.getElementById('toggle-panel').title = 'Masquer panneau';
            }
        } else {
            panel.classList.add('hidden');
            // Change to reopen icon (chevron left)
            if (icon) {
                icon.innerHTML = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 20l-3 -8l3 -8" />';
                document.getElementById('toggle-panel').title = 'Afficher panneau';
            }
        }
    };

    // Toggle fullscreen function
    window.toggleFullscreen = function() {
        if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement) {
            // Exit fullscreen
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        } else {
            // Enter fullscreen
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            }
        }
    };

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey) {
            if (e.key === 'ArrowRight') {
                e.preventDefault();
                togglePanelHide();
            } else if (e.key === 'ArrowLeft') {
                e.preventDefault();
                togglePanelShow();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                showControlsTemporarily();
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                hideControlsImmediately();
            }
        }
    });

    // Functions for shortcuts
    function togglePanelHide() {
        const panel = document.getElementById('episode-info');
        if (!panel.classList.contains('hidden')) {
            togglePanel();
        }
    }
    function togglePanelShow() {
        const panel = document.getElementById('episode-info');
        if (panel.classList.contains('hidden')) {
            togglePanel();
        }
    }
    function showControlsTemporarily() {
        showControls();
    }
    function hideControlsImmediately() {
        clearTimeout(hideTimeout);
        hideControls();
    }

    // Auto-hide controls in fullscreen
    let hideTimeout;
    function hideControls() {
        document.getElementById('top-controls').style.opacity = '0';
        document.getElementById('back-button').style.opacity = '0';
    }
    function showControls() {
        document.getElementById('top-controls').style.opacity = '1';
        document.getElementById('back-button').style.opacity = '1';
        clearTimeout(hideTimeout);
        hideTimeout = setTimeout(hideControls, 3000);
    }
    document.addEventListener('fullscreenchange', function() {
        if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement) {
            // Entered fullscreen
            showControls(); // Show initially
            // Hide panel
            const panel = document.getElementById('episode-info');
            if (!panel.classList.contains('hidden')) {
                togglePanel();
            }
        } else {
            // Exited fullscreen
            document.getElementById('top-controls').style.opacity = '1';
            document.getElementById('back-button').style.opacity = '1';
            clearTimeout(hideTimeout);
            // Show panel
            const panel = document.getElementById('episode-info');
            if (panel.classList.contains('hidden')) {
                togglePanel();
            }
        }
    });
    document.addEventListener('mousemove', showControls);
    // Also attach to video overlay
    const videoOverlay = document.getElementById('video-overlay');
    if (videoOverlay) {
        videoOverlay.addEventListener('mousemove', showControls);
    }

    // Attach event listeners to episode links and select
    function attachEventListeners() {
        // Episode navigation links
        const episodeLinks = document.querySelectorAll('a[href*="/play/series/"]');
        episodeLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                loadEpisode(this.href);
            });
        });

        // Source select
        const sourceSelect = document.querySelector('select[onchange]');
        if (sourceSelect) {
            sourceSelect.addEventListener('change', function(e) {
                e.preventDefault();
                loadEpisode(this.value);
            });
            // Remove the onchange attribute to prevent double handling
            sourceSelect.removeAttribute('onchange');
        }
    }

    // Initial attachment
    attachEventListeners();
});
</script>
</html>
