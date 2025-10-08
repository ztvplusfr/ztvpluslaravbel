<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'title',
        'original_title',
        'overview',
        'genres',
        'release_date',
        'language',
        'poster_path',
        'backdrop_path',
        'popularity',
        'vote_average',
        'vote_count',
        'duration',
        'is_active',
        'trailer_id',
        'age_rating',
        'network_id',
    ];

    protected $casts = [
        'genres' => 'array',
        'release_date' => 'date',
        'popularity' => 'float',
        'vote_average' => 'float',
        'vote_count' => 'integer',
        'duration' => 'integer',
        'is_active' => 'boolean',
        'network_id' => 'integer',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Get the network (channel) of the movie
     */
    public function network()
    {
        return $this->belongsTo(Network::class);
    }
}