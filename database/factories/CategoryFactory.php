<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(rand(1, 2), true);

        return [
            'name'        => ucwords($name),
            'slug'        => Str::slug($name),
            'description' => fake()->sentence(),
            'is_active'   => true,
            'sort_order'  => fake()->numberBetween(1, 100),
        ];
    }
}
