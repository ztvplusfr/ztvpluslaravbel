<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::all();
        return view('series.index', compact('series'));
    }
    /**
     * Show details for a single series
     */
    /**
     * Show details for a single series with episode selector
     */
    public function show(Request $request, $id)
    {
        $series = Series::with('seasons', 'network')->findOrFail($id);
        // Determine selected season by query param or default to first
        $selectedSeason = $series->seasons->first();
        if ($request->has('season')) {
            $found = $series->seasons->firstWhere('id', $request->query('season'));
            if ($found) {
                $selectedSeason = $found;
            }
        }
        // Load episodes for selected season
        $orderDirection = $request->get('order', 'asc');
        $episodes = $selectedSeason->episodes()->where('is_active', true)->orderBy('episode_number', $orderDirection)->get();
        return view('series.show', compact('series', 'selectedSeason', 'episodes', 'orderDirection', 'request'));
    }

    /**
     * Play an episode
     */
    public function play(Request $request, $series_id, $season_number, $episode_number)
    {
        $episode = Episode::with('videos', 'season.series')
            ->whereHas('season', function ($query) use ($series_id, $season_number) {
                $query->where('series_id', $series_id)->where('season_number', $season_number);
            })
            ->where('episode_number', $episode_number)
            ->firstOrFail();

        $videos = $episode->videos->where('is_active', true);
        if ($videos->isEmpty()) {
            $video = null;
        } else {
            // Select video via query param or first
            $video = $videos->first();
            if ($request->has('video')) {
                $selected = $videos->firstWhere('id', $request->query('video'));
                if ($selected) {
                    $video = $selected;
                }
            }
        }

        // Get next and previous episodes
        $seasonEpisodes = $episode->season->episodes()->where('is_active', true)->orderBy('episode_number')->get();
        $currentIndex = $seasonEpisodes->search(function ($ep) use ($episode_number) {
            return $ep->episode_number == $episode_number;
        });
        $prevEpisode = $currentIndex > 0 ? $seasonEpisodes[$currentIndex - 1] : null;
        $nextEpisode = $currentIndex < $seasonEpisodes->count() - 1 ? $seasonEpisodes[$currentIndex + 1] : null;

        // Get next 5 episodes
        $nextEpisodes = $seasonEpisodes->slice($currentIndex + 1);

        return view('series.play', compact('episode', 'video', 'videos', 'prevEpisode', 'nextEpisode', 'nextEpisodes'));
    }
}
