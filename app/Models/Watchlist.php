<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Watchlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'watchable_type',
        'watchable_id',
        'status',
        'rating',
        'notes',
    ];

    protected $casts = [
        'rating' => 'integer',
        'status' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        // Map short names to full class names for polymorphic relationships
        Relation::morphMap([
            'movie' => \App\Models\Movie::class,
            'series' => \App\Models\Series::class,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function watchable()
    {
        return $this->morphTo();
    }

    // Helper methods
    public function isToWatch()
    {
        return $this->status === 'to_watch';
    }

    public function isWatching()
    {
        return $this->status === 'watching';
    }

    public function isWatched()
    {
        return $this->status === 'watched';
    }

    public function isDropped()
    {
        return $this->status === 'dropped';
    }
}
