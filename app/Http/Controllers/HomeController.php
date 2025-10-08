<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Series;
use App\Models\Network;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer 3 films et 3 séries populaires ou aléatoires
        $movies = Movie::where('is_active', true)->orderBy('popularity', 'desc')->take(3)->get();
        $series = Series::where('is_active', true)->orderBy('popularity', 'desc')->take(3)->get();

        // Mélanger et prendre 6 éléments
        $featuredItems = $movies->concat($series)->shuffle()->take(6);

        // Derniers films sortis
        $latestMovies = Movie::where('is_active', true)->orderBy('release_date', 'desc')->take(10)->get();
        // Dernières séries sorties
        $latestSeries = Series::where('is_active', true)->orderBy('first_air_date', 'desc')->take(10)->get();
        // Récupérer toutes les chaînes
        $networks = Network::all();

        // Préparer les statuts de watchlist pour les éléments en vedette
        $watchlistStatuses = [];
        if (auth()->check()) {
            foreach ($featuredItems as $item) {
                $type = $item instanceof Movie ? 'movie' : 'series';
                $existing = auth()->user()->watchlists()
                    ->where('watchable_type', $type)
                    ->where('watchable_id', $item->id)
                    ->first();
                $watchlistStatuses[$item->id] = $existing ? [
                    'in_watchlist' => true,
                    'status' => $existing->status
                ] : [
                    'in_watchlist' => false,
                    'status' => null
                ];
            }
        } else {
            // Pour les utilisateurs non connectés, tout est false
            foreach ($featuredItems as $item) {
                $watchlistStatuses[$item->id] = [
                    'in_watchlist' => false,
                    'status' => null
                ];
            }
        }

        return view('home', compact('featuredItems', 'latestMovies', 'latestSeries', 'networks', 'watchlistStatuses'));
    }
}