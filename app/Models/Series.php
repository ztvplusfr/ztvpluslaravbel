<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'title',
        'original_title',
        'overview',
        'genres',
        'first_air_date',
        'language',
        'poster_path',
        'backdrop_path',
        'popularity',
        'vote_average',
        'vote_count',
        'is_active',
        'age_rating',
        'network_id',
    ];

    protected $casts = [
        'genres' => 'array',
        'first_air_date' => 'date',
        'popularity' => 'float',
        'vote_average' => 'float',
        'vote_count' => 'integer',
        'is_active' => 'boolean',
        'age_rating' => 'string',
        'network_id' => 'integer',
    ];

    // Append computed attributes for badges
    protected $appends = [
        'release_year',
        'seasons_count',
        'episodes_count',
    ];

    /**
     * Get release year from first_air_date
     */
    public function getReleaseYearAttribute()
    {
        return $this->first_air_date ? $this->first_air_date->format('Y') : null;
    }

    /**
     * Count related seasons
     */
    public function getSeasonsCountAttribute()
    {
        return $this->seasons()->count();
    }

    /**
     * Count related episodes across seasons
     */
    public function getEpisodesCountAttribute()
    {
        return $this->episodes()->count();
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    /**
     * Get the network (channel) of the series
     */
    public function network()
    {
        return $this->belongsTo(Network::class);
    }
    /**
     * Get all episodes through seasons
     */
    public function episodes()
    {
        return $this->hasManyThrough(
            \App\Models\Episode::class,
            \App\Models\Season::class,
            'series_id', // Foreign key on seasons table
            'season_id', // Foreign key on episodes table
            'id',        // Local key on series table
            'id'         // Local key on seasons table
        );
    }
}
