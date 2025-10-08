<?php

namespace App\Http\Controllers;

use App\Models\Network;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    /**
     * Display the specified network with its movies and series.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $network = Network::with(['movies', 'series'])->findOrFail($id);

        return view('network.show', compact('network'));
    }
}