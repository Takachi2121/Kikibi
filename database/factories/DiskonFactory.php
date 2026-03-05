<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diskon>
 */
class DiskonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $produk = Produk::pluck('id')->toArray();
        return [
            'produk_id' => $this->faker->unique()->randomElement($produk),
            'diskon' => $this->faker->numberBetween(10, 50),
            'harga_akhir' => $this->faker->numberBetween(100000, 200000),
            'tanggal_selesai' => $this->faker->dateTimeBetween('now', '+30 days'),
        ];
    }
}
