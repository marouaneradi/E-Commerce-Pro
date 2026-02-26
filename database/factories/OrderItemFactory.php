<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $price    = fake()->randomFloat(2, 5, 300);
        $quantity = fake()->numberBetween(1, 5);

        return [
            'order_id'      => Order::factory(),
            'product_id'    => Product::factory(),
            'product_name'  => fake()->words(3, true),
            'product_image' => null,
            'quantity'      => $quantity,
            'price'         => $price,
            'total'         => $price * $quantity,
        ];
    }
}
