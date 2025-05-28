<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incident>
 */
class IncidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => Str::of(Str::random(6))->lower(),
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence(),
            'category' => $this->faker->word(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'status' => $this->faker->randomElement(['open', 'closed']),
            'incident' => $this->faker->word(),
            'bairro' => $this->faker->word(),
            'public_visibility' => $this->faker->boolean(80), // 80% chance of being true
        ];
    }
}
