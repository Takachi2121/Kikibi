<?php

namespace Database\Factories;

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
        return [
            'produk_id' => $this->fake()->randomElement(3, 10)->unique(),
            'diskon' => $this->fake()->randomElement(10, 50),
            'harga_akhir' => $this->fake()->randomElement(100000, 200000),
            'tanggal_mulai' => $this->fake()->date(),
            'tanggal_selesai' => $this->fake()->date(),
        ];
    }
}
