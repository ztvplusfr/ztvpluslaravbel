<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Importer</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-background text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-900 p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-semibold text-primary mb-6 text-center">Importer depuis TMDB</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-600 text-white rounded">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-600 text-white rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.import') }}" class="space-y-4">
            @csrf
            <div>
                <label for="type" class="block mb-1 text-sm">Type</label>
                <select id="type" name="type" required class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:ring-2 focus:ring-primary text-white">
                    <option value="movie">Film</option>
                    <option value="tv">Série</option>
                </select>
            </div>
            <div>
                <label for="tmdb_id" class="block mb-1 text-sm">ID TMDB</label>
                <input id="tmdb_id" name="tmdb_id" type="number" required class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:ring-2 focus:ring-primary text-white" />
            </div>
            <button type="submit" class="w-full py-2 bg-primary text-black font-semibold rounded hover:bg-opacity-90 transition">Importer</button>
        </form>
    </div>
</body>
</html>
