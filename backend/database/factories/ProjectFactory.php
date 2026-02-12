<?php

namespace Database\Factories;

use App\Enums\Access;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
        'title' => fake()->text(),
        'client'=> fake()->name(),
        'is_tracked'=> fake()->boolean(),
        'progress'=>fake()->randomDigit(),
        'access'=>fake()->randomElement(Access::class),
        ];
    }
}
