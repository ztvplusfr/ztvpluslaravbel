<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Series;
use App\Models\Season;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'movies' => Movie::count(),
            'series' => Series::count(),
            'seasons' => Season::count(),
            'episodes' => Episode::count(),
        ];
        return view('admin', compact('stats'));
    }

    public function movies()
    {
        $movies = Movie::all();
        return view('admin.movies', compact('movies'));
    }

    public function editMovie($id)
    {
        $movie = Movie::with('videos')->findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    public function updateMovie(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $validated = $request->validate([
            'tmdb_id' => 'required|integer',
            'title' => 'required|string',
            'original_title' => 'nullable|string',
            'overview' => 'nullable|string',
            'genres' => 'nullable|string',
            'release_date' => 'nullable|date',
            'language' => 'nullable|string',
            'poster_path' => 'nullable|url',
            'backdrop_path' => 'nullable|url',
            'popularity' => 'nullable|numeric',
            'vote_average' => 'nullable|numeric',
            'vote_count' => 'nullable|integer',
            'is_active' => 'boolean',
            'trailer_id' => 'nullable|string',
            'age_rating' => 'nullable|string',
        ]);

        // Convert genres string to array if needed
        if (isset($validated['genres'])) {
            $validated['genres'] = array_map('trim', explode(',', $validated['genres']));
        }

        $movie->update($validated);

        return redirect()->route('admin.movies.edit', $movie)->with('success', 'Film mis à jour avec succès.');
    }

    public function series()
    {
        $series = Series::all();
        return view('admin.series', compact('series'));
    }

    public function editSerie($id)
    {
        $serie = Series::with('seasons.episodes')->findOrFail($id);
        return view('admin.series.edit', compact('serie'));
    }

    public function editSeason($id)
    {
        $season = Season::with('episodes')->findOrFail($id);
        return view('admin.seasons.edit', compact('season'));
    }

    public function editEpisode($id)
    {
        $episode = Episode::findOrFail($id);
        return view('admin.episodes.edit', compact('episode'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
}