<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function index()
    {
        // Pour l'instant, utiliser Series. À ajuster si un modèle Anime est ajouté.
        $animes = Series::all(); // Ou filtrer par genre 'anime' si le modèle le permet
        return view('animes.index', compact('animes'));
    }
}