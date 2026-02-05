<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    /** @use HasFactory<\Database\Factories\PesananFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produk_id',
        'jumlah',
        'total_harga',
    ];
}
