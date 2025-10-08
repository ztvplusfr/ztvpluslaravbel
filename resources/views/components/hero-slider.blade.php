<div class="relative w-full h-96 bg-gray-900 overflow-hidden">
    @if($featuredItems->isNotEmpty())
    <!-- Slides -->
    <div class="slider-container flex transition-transform duration-500 ease-in-out" id="slider">
        @foreach($featuredItems as $item)
        <div class="slide flex-shrink-0 w-full h-full relative">
            @if($item->backdrop_path)
                <img src="https://image.tmdb.org/t/p/w1280{{ $item->backdrop_path }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                    <span class="text-white text-2xl">Image non disponible</span>
                </div>
            @endif
            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-start pl-8">
                <div class="text-white max-w-md">
                    <h2 class="text-4xl font-bold mb-4">{{ $item->title }}</h2>
                    <p class="text-lg mb-6 line-clamp-3">{{ Str::limit($item->overview, 150) }}</p>
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="bg-primary text-background px-2 py-1 rounded text-sm">{{ $item instanceof \App\Models\Movie ? 'Film' : 'Série' }}</span>
                        <span class="text-sm">{{ $item->release_date ?? $item->first_air_date ? \Carbon\Carbon::parse($item->release_date ?? $item->first_air_date)->format('Y') : '' }}</span>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="text-sm">{{ number_format($item->vote_average, 1) }}</span>
                        </div>
                    </div>
                    <a href="{{ $item instanceof \App\Models\Movie ? route('movies.index') : route('series.index') }}" class="bg-primary text-background px-6 py-3 rounded-lg hover:bg-opacity-80 transition inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        Regarder
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Navigation buttons -->
    <button class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75" onclick="prevSlide()">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75" onclick="nextSlide()">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    <!-- Dots -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        @for($i = 0; $i < $featuredItems->count(); $i++)
        <button class="w-3 h-3 bg-white bg-opacity-50 rounded-full" onclick="goToSlide({{ $i }})"></button>
        @endfor
    </div>
    @endif
</div>

<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.bottom-4 button');

function showSlide(index) {
    const slider = document.getElementById('slider');
    slider.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach((dot, i) => {
        dot.classList.toggle('bg-opacity-100', i === index);
        dot.classList.toggle('bg-opacity-50', i !== index);
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
}

function goToSlide(index) {
    currentSlide = index;
    showSlide(currentSlide);
}

// Auto slide
setInterval(nextSlide, 5000);

// Initialize
if (slides.length > 0) {
    showSlide(0);
}
</script>