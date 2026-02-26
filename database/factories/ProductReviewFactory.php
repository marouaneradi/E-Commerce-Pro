<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReview>
 */
class ProductReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id'  => Product::factory(),
            'user_id'     => User::factory(),
            'rating'      => fake()->numberBetween(1, 5),
            'title'       => fake()->optional()->sentence(4),
            'body'        => fake()->optional()->paragraph(),
            'is_approved' => true,
        ];
    }

    public function pending(): static
    {
        return $this->state(['is_approved' => false]);
    }
}
