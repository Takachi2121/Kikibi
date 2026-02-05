<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kategori_id' => Kategori::factory(),
            'nama_produk' => $this->faker->word,
            'deskripsi' => $this->faker->sentence,
            'harga' => $this->faker->numberBetween(100000, 1000000),
            'umur_min' => $this->faker->numberBetween(1, 18),
            'umur_max' => $this->faker->numberBetween(19, 30),
            'untuk_gender' => $this->faker->randomElement(['Pria', 'Wanita']),
            'untuk_momen' => implode(', ', $this->faker->randomElements([
                'Ulang Tahun',
                'Valentine',
                'Anniversary',
                'Hari Ibu',
                'Wisuda'
            ], rand(1, 3))),
            'estimasi' => $this->faker->sentence,
        ];
    }
}
