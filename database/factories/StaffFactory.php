<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'uuid' => fake()->uuid(),
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'image'=> fake()->imageUrl(),
        'position_id' => fake()->numberBetween(1, 5),
        'id_number' => fake()->unique()->numberBetween(100000000, 999999999),
        'sex' => fake()->randomElement(['pria', 'wanita']),
        'phone' => fake()->phoneNumber(),
        ];
    }
}
