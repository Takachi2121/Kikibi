<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    /** @use HasFactory<\Database\Factories\TestimoniFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'rating',
        'komentar',
        'foto',
    ];
}
