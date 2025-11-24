<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    Use HasFactory;

    protected $fillable = [
        'title',
        'release_year',
        'developer',
        'publisher',
        'platform_id'
    ];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
