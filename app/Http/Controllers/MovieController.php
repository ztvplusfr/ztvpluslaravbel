<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('movies.index', compact('movies'));
    }

    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('movies.show', compact('movie'));
    }

    public function trailer($id)
    {
        $movie = Movie::findOrFail($id);
        return view('movies.trailer', compact('movie'));
    }

    /**
     * Play the first active video of the movie
     */
    /**
     * Play the selected or first available video of the movie, with source selection
     */
    public function play(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);
        // Récupère toutes les vidéos actives
        $videos = $movie->videos()->where('is_active', true)->get();
        if ($videos->isEmpty()) {
            abort(404, 'Aucun contenu vidéo disponible pour ce film.');
        }
        // Sélection via query param, fallback sur la première
        $video = $videos->first();
        if ($request->has('video')) {
            $selected = $videos->firstWhere('id', $request->query('video'));
            if ($selected) {
                $video = $selected;
            }
        }
        return view('movies.play', compact('movie', 'video', 'videos'));
    }

    /**
     * Recherche de films par titre
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $movies = Movie::where('title', 'like', "%{$query}%")->get();
        // Search series by title as well
        $series = \App\Models\Series::where('title', 'like', "%{$query}%")->get();
        return view('movies.search', compact('movies', 'series', 'query'));
    }
}
