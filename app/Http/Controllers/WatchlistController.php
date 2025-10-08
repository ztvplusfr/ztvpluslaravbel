<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Series;

class WatchlistController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $type = $request->get('type', 'all');

        $query = $user->watchlists()->with('watchable');

        if ($type !== 'all') {
            $query->where('watchable_type', $type);
        }

        // Get all watchlists sorted by created_at desc
        $allWatchlists = $query->orderBy('created_at', 'desc')->get();

        // Group by date (Y-m-d) and sort groups by date desc
        $groupedWatchlists = $allWatchlists->groupBy(function ($watchlist) {
            return $watchlist->created_at->format('Y-m-d');
        })->sortKeysDesc();

        // Convert dates to formatted French dates for display
        $formattedGroups = [];
        foreach ($groupedWatchlists as $date => $items) {
            $formattedDate = \Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd D MMMM YYYY'); // e.g., "lundi 8 octobre 2025"
            $formattedGroups[$formattedDate] = $items;
        }

        $types = [
            'all' => 'Tous',
            'movie' => 'Films',
            'series' => 'Séries',
        ];

        $statuses = [
            'to_watch' => 'À voir',
            'watching' => 'En cours',
            'watched' => 'Terminé',
            'dropped' => 'Abandonné',
        ];

        return view('watchlist', compact('formattedGroups', 'type', 'types', 'statuses'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:movie,series',
        ]);

        $user = auth()->user();
        $id = $request->input('id');
        $type = $request->input('type');

        $model = $type === 'movie' ? Movie::class : Series::class;
        $item = $model::findOrFail($id);

        $existing = $user->watchlists()
            ->where('watchable_type', $type)
            ->where('watchable_id', $item->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['added' => false, 'message' => 'Retiré de la watchlist']);
        } else {
            $user->watchlists()->create([
                'watchable_type' => $type,
                'watchable_id' => $item->id,
                'status' => 'to_watch',
            ]);
            return response()->json(['added' => true, 'message' => 'Ajouté à la watchlist']);
        }
    }

    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:movie,series',
        ]);

        $user = auth()->user();
        $id = $request->input('id');
        $type = $request->input('type');

        \Log::info('Watchlist status check', [
            'user_id' => $user ? $user->id : 'guest',
            'item_id' => $id,
            'item_type' => $type,
            'authenticated' => auth()->check()
        ]);

        // If user is not authenticated, return not in watchlist
        if (!$user) {
            return response()->json([
                'in_watchlist' => false,
                'status' => null,
                'message' => 'Utilisateur non authentifié'
            ]);
        }

        $model = $type === 'movie' ? Movie::class : Series::class;
        $item = $model::findOrFail($id);

        $existing = $user->watchlists()
            ->where('watchable_type', $type)
            ->where('watchable_id', $item->id)
            ->first();

        if ($existing) {
            return response()->json([
                'in_watchlist' => true,
                'status' => $existing->status,
                'message' => 'Élément trouvé dans la watchlist'
            ]);
        } else {
            return response()->json([
                'in_watchlist' => false,
                'status' => null,
                'message' => 'Élément non trouvé dans la watchlist'
            ]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:movie,series',
            'status' => 'required|in:to_watch,watching,watched,dropped,remove',
        ]);

        $user = auth()->user();
        $id = $request->input('id');
        $type = $request->input('type');
        $status = $request->input('status');

        // If user is not authenticated, return error
        if (!$user) {
            return response()->json([
                'error' => 'Authentication required',
                'message' => 'Vous devez être connecté pour gérer votre watchlist'
            ], 401);
        }

        $model = $type === 'movie' ? Movie::class : Series::class;
        $item = $model::findOrFail($id);

        if ($status === 'remove') {
            $deleted = $user->watchlists()
                ->where('watchable_type', $type)
                ->where('watchable_id', $item->id)
                ->delete();

            if ($deleted) {
                return response()->json([
                    'in_watchlist' => false,
                    'message' => 'Retiré de la watchlist'
                ]);
            } else {
                return response()->json([
                    'in_watchlist' => false,
                    'message' => 'Élément non trouvé dans la watchlist'
                ], 404);
            }
        }

        $watchlist = $user->watchlists()
            ->where('watchable_type', $type)
            ->where('watchable_id', $item->id)
            ->first();

        if ($watchlist) {
            $watchlist->update(['status' => $status]);
            $statusLabels = [
                'to_watch' => 'À voir',
                'watching' => 'En cours',
                'watched' => 'Terminé',
                'dropped' => 'Abandonné'
            ];

            return response()->json([
                'in_watchlist' => true,
                'status' => $status,
                'message' => 'Statut mis à jour : ' . $statusLabels[$status]
            ]);
        } else {
            $user->watchlists()->create([
                'watchable_type' => $type,
                'watchable_id' => $item->id,
                'status' => $status,
            ]);

            $statusLabels = [
                'to_watch' => 'À voir',
                'watching' => 'En cours',
                'watched' => 'Terminé',
                'dropped' => 'Abandonné'
            ];

            return response()->json([
                'in_watchlist' => true,
                'status' => $status,
                'message' => 'Ajouté à la watchlist : ' . $statusLabels[$status]
            ]);
        }
    }
}
