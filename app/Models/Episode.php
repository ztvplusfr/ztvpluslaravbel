<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'tmdb_id',
        'episode_number',
        'title',
        'overview',
        'air_date',
        'still_path',
        'duration',
        'vote_average',
        'vote_count',
        'is_active',
    ];

    protected $casts = [
        'air_date' => 'date',
        'duration' => 'integer',
        'vote_average' => 'float',
        'vote_count' => 'integer',
        'is_active' => 'boolean',
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
