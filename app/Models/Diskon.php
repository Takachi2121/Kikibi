<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    /** @use HasFactory<\Database\Factories\DiskonFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $filled = [
        'produk_id',
        'diskon',
        'harga_akhir',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
