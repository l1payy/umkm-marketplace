<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Need>
 */
class NeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'budget_min' => $this->faker->randomFloat(2, 1000000, 3000000),
            'budget_max' => $this->faker->randomFloat(2, 3000000, 6000000),
            'reference_image_path' => null,
            'status' => 'open',
        ];
    }
}
