<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Notifikasi;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Testimoni;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Pesanan::factory(10)->create();
        Testimoni::factory(7)->create();
        Notifikasi::factory(10)->create();

        User::create([
            'nama_lengkap' => 'Admin',
            'email' => 'kikibi@gmail.com',
            'no_telp' => '08123456789',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'nama_lengkap' => 'Andre',
            'email' => 'andremm73@gmail.com',
            'no_telp' => '08123456789',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
