<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name  = fake()->words(rand(2, 4), true);
        $price = fake()->randomFloat(2, 5, 999);

        return [
            'category_id'       => Category::factory(),
            'name'              => ucwords($name),
            'slug'              => Str::slug($name) . '-' . fake()->unique()->randomNumber(4),
            'description'       => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(15),
            'price'             => $price,
            'compare_price'     => fake()->optional(0.4)->randomFloat(2, $price, $price * 1.5),
            'stock'             => fake()->numberBetween(0, 200),
            'sku'               => strtoupper(fake()->unique()->bothify('PRD-####-????')),
            'is_active'         => true,
            'is_featured'       => fake()->boolean(20),
            'average_rating'    => fake()->randomFloat(1, 3, 5),
            'reviews_count'     => fake()->numberBetween(0, 150),
        ];
    }

    public function active(): static
    {
        return $this->state(['is_active' => true]);
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }

    public function outOfStock(): static
    {
        return $this->state(['stock' => 0]);
    }
}
