<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZTV Plus - Animes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-text">
    <x-navbar :currentRoute="request()->route()->getName()" />

    <main class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8 text-primary">Animes</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($animes as $anime)
                <div class="bg-gray-800 p-4 rounded-lg">
                    <h2 class="text-xl font-semibold mb-2">{{ $anime->title }}</h2>
                    <p class="text-sm text-gray-400">{{ $anime->overview ?? 'Description non disponible' }}</p>
                </div>
            @empty
                <p class="text-center col-span-full">Aucun anime disponible pour le moment.</p>
            @endforelse
        </div>
    </main>
</body>
</html>