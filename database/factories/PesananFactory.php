<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pesanan>
 */
class PesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'produk_id' => Produk::factory(),
            'jumlah' => $this->faker->numberBetween(1, 5),
            'total_harga' => $this->faker->numberBetween(100000, 1000000),
            'status' => $this->faker->randomElement(['Pending', 'Dikirim', 'Selesai']),
        ];
    }
}
