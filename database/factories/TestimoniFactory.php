<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimoni>
 */
class TestimoniFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'komentar' => fake()->sentence(),
            'rating' => fake()->numberBetween(4, 5),
            'foto' => fake()->randomElement([
                'Person 1.png',
                'Person 2.png',
                'Person 3.png',
                'Person 4.png',
                'Person 5.png',
                'Person 6.png',
            ]),
        ];
    }
}
