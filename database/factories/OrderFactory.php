<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 20, 500);
        $tax      = round($subtotal * 0.08, 2);
        $shipping = $subtotal >= 100 ? 0 : 9.99;

        return [
            'user_id'        => User::factory(),
            'order_number'   => 'ORD-' . strtoupper(uniqid()),
            'status'         => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'subtotal'       => $subtotal,
            'tax'            => $tax,
            'shipping'       => $shipping,
            'total'          => $subtotal + $tax + $shipping,
            'first_name'     => fake()->firstName(),
            'last_name'      => fake()->lastName(),
            'email'          => fake()->email(),
            'phone'          => fake()->optional()->phoneNumber(),
            'address'        => fake()->streetAddress(),
            'city'           => fake()->city(),
            'state'          => fake()->state(),
            'zip_code'       => fake()->postcode(),
            'country'        => 'US',
            'payment_method' => fake()->randomElement(['cod', 'card', 'paypal']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
