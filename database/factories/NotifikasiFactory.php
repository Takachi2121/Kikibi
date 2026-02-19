<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notifikasi>
 */
class NotifikasiFactory extends Factory
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
            'pesan' => $this->faker->sentence,
            'is_read' => $this->faker->randomElement(['0', '1']),
            'jenis_notif' => $this->faker->randomElement(['0', '1', '2', '3']),
        ];
    }
}
