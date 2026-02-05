<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'untuk_min',
        'untuk_max',
        'untuk_gender',
        'untuk_momen',
        'estimasi',
        'foto_1',
        'foto_2',
        'foto_3',
        'foto_4',
        'foto_5',
    ];
}
