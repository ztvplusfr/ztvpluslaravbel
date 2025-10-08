<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function create(Movie $movie)
    {
        return view('admin.videos.create', compact('movie'));
    }

    public function store(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'embed_link' => 'required|url',
            'language' => 'required|string',
            'quality' => 'required|string',
            'server_name' => 'required|string',
            'subtitle' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $video = $movie->videos()->create($validated);

        return redirect()->route('admin.movies.edit', $movie)->with('success', 'Vidéo ajoutée avec succès.');
    }

    public function edit(Movie $movie, Video $video)
    {
        return view('admin.videos.edit', compact('movie', 'video'));
    }

    public function update(Request $request, Movie $movie, Video $video)
    {
        $validated = $request->validate([
            'embed_link' => 'required|url',
            'language' => 'required|string',
            'quality' => 'required|string',
            'server_name' => 'required|string',
            'subtitle' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $video->update($validated);

        return redirect()->route('admin.movies.edit', $movie)->with('success', 'Vidéo mise à jour avec succès.');
    }

    public function destroy(Movie $movie, Video $video)
    {
        $video->delete();

        return redirect()->route('admin.movies.edit', $movie)->with('success', 'Vidéo supprimée avec succès.');
    }
}