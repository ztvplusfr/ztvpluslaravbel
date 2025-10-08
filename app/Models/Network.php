<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];

    /**
     * Movies belonging to this network
     */
    public function movies()
    {
        return $this->hasMany(Movie::class, 'network_id');
    }

    /**
     * Series belonging to this network
     */
    public function series()
    {
        return $this->hasMany(Series::class, 'network_id');
    }
}
