<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Series;
use App\Models\Season;
use App\Models\Episode;

class AdminImportController extends Controller
{
    /**
     * Affiche le formulaire d'import.
     */
    public function showImportForm()
    {
        return view('admin.import');
    }

    /**
     * Traite l'import depuis TMDB.
     */
    public function import(Request $request)
    {
        $request->validate([
            'type' => 'required|in:movie,tv',
            'tmdb_id' => 'required|numeric',
        ]);

        $apiKey = config('services.tmdb.api_key');
        $type = $request->type;
        $tmdbId = $request->tmdb_id;

        // Fetch details with seasons for TV
        // Construire l'endpoint et les paramètres selon le type
        if ($type === 'movie') {
            $endpoint = "movie/{$tmdbId}";
            $query = "?api_key={$apiKey}&language=fr-FR";
        } else {
            $endpoint = "tv/{$tmdbId}";
            $query = "?api_key={$apiKey}&language=fr-FR&append_to_response=seasons";
        }
        $response = Http::get("https://api.themoviedb.org/3/{$endpoint}{$query}");

        if ($response->failed()) {
            return back()->withErrors(['tmdb_id' => 'Impossible de récupérer les données TMDB.']);
        }

        $data = $response->json();
        $baseImageUrl = 'https://image.tmdb.org/t/p/original';
        if ($type === 'movie') {
            // Import d'un film
            $genres = collect($data['genres'] ?? [])->pluck('name')->all();
            Movie::updateOrCreate(
                ['tmdb_id' => $data['id']],
                [
                    'title' => $data['title'] ?? '',
                    'original_title' => $data['original_title'] ?? null,
                    'overview' => $data['overview'] ?? null,
                    'genres' => $genres,
                    'release_date' => $data['release_date'] ?? null,
                    'language' => $data['original_language'] ?? 'fr',
                    'poster_path' => isset($data['poster_path']) ? $baseImageUrl . $data['poster_path'] : null,
                    'backdrop_path' => isset($data['backdrop_path']) ? $baseImageUrl . $data['backdrop_path'] : null,
                    'popularity' => $data['popularity'] ?? 0,
                    'vote_average' => $data['vote_average'] ?? 0,
                    'vote_count' => $data['vote_count'] ?? 0,
                    'duration' => $data['runtime'] ?? null,
                    'is_active' => true,
                ]
            );
        } else {
            // Import d'une série et de ses saisons/épisodes
            $genres = collect($data['genres'] ?? [])->pluck('name')->all();
            $series = Series::updateOrCreate(
                ['tmdb_id' => $data['id']],
                [
                    'title' => $data['name'] ?? '',
                    'original_title' => $data['original_name'] ?? null,
                    'overview' => $data['overview'] ?? null,
                    'genres' => $genres,
                    'first_air_date' => $data['first_air_date'] ?? null,
                    'language' => $data['original_language'] ?? 'fr',
                    'poster_path' => isset($data['poster_path']) ? $baseImageUrl . $data['poster_path'] : null,
                    'backdrop_path' => isset($data['backdrop_path']) ? $baseImageUrl . $data['backdrop_path'] : null,
                    'popularity' => $data['popularity'] ?? 0,
                    'vote_average' => $data['vote_average'] ?? 0,
                    'vote_count' => $data['vote_count'] ?? 0,
                    'is_active' => true,
                ]
            );
            // Traiter les saisons
            foreach ($data['seasons'] ?? [] as $s) {
                $season = Season::updateOrCreate(
                    ['series_id' => $series->id, 'season_number' => $s['season_number']],
                    [
                        'title' => $s['name'] ?? null,
                        'overview' => $s['overview'] ?? null,
                        'poster_path' => isset($s['poster_path']) ? $baseImageUrl . $s['poster_path'] : null,
                        'air_date' => $s['air_date'] ?? null,
                        'is_active' => true,
                    ]
                );
                // Récupérer les épisodes de la saison
                $epsResp = Http::get("https://api.themoviedb.org/3/tv/{$tmdbId}/season/{$s['season_number']}?api_key={$apiKey}&language=fr-FR");
                if ($epsResp->ok()) {
                    $episodes = $epsResp->json()['episodes'] ?? [];
                    foreach ($episodes as $e) {
                        Episode::updateOrCreate(
                            ['season_id' => $season->id, 'episode_number' => $e['episode_number']],
                            [
                                'tmdb_id' => $tmdbId,
                                'title' => $e['name'] ?? '',
                                'overview' => $e['overview'] ?? null,
                                'air_date' => $e['air_date'] ?? null,
                                'still_path' => isset($e['still_path']) ? $baseImageUrl . $e['still_path'] : null,
                                'vote_average' => $e['vote_average'] ?? 0,
                                'vote_count' => $e['vote_count'] ?? 0,
                                'is_active' => true,
                            ]
                        );
                    }
                }
            }
        }
        return back()->with('success', ucfirst($type) . ' importé avec succès !');
    }
}