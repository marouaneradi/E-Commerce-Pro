<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Regular users
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $users[] = User::create([
                'name' => "User {$i}",
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Categories
        $categoryData = [
            ['name' => 'Electronics', 'description' => 'Latest gadgets and electronics', 'sort_order' => 1],
            ['name' => 'Clothing', 'description' => 'Fashion and apparel', 'sort_order' => 2],
            ['name' => 'Books', 'description' => 'Books and literature', 'sort_order' => 3],
            ['name' => 'Home & Garden', 'description' => 'Home decor and garden essentials', 'sort_order' => 4],
            ['name' => 'Sports', 'description' => 'Sports equipment and gear', 'sort_order' => 5],
            ['name' => 'Beauty', 'description' => 'Beauty and personal care', 'sort_order' => 6],
        ];

        $categories = [];
        foreach ($categoryData as $data) {
            $categories[] = Category::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'is_active' => true,
                'sort_order' => $data['sort_order'],
            ]);
        }

        // Products
        $productsData = [
            // Electronics
            ['name' => 'iPhone 15 Pro', 'price' => 999.99, 'compare_price' => 1099.99, 'stock' => 50, 'featured' => true, 'category' => 0],
            ['name' => 'Samsung Galaxy S24', 'price' => 849.99, 'compare_price' => 949.99, 'stock' => 40, 'featured' => true, 'category' => 0],
            ['name' => 'Sony WH-1000XM5 Headphones', 'price' => 349.99, 'compare_price' => 399.99, 'stock' => 30, 'featured' => false, 'category' => 0],
            ['name' => 'Apple MacBook Air M3', 'price' => 1299.99, 'compare_price' => null, 'stock' => 20, 'featured' => true, 'category' => 0],
            ['name' => 'iPad Pro 12.9"', 'price' => 1099.99, 'compare_price' => 1199.99, 'stock' => 25, 'featured' => false, 'category' => 0],
            // Clothing
            ['name' => 'Premium Cotton T-Shirt', 'price' => 29.99, 'compare_price' => 39.99, 'stock' => 100, 'featured' => false, 'category' => 1],
            ['name' => 'Classic Denim Jeans', 'price' => 79.99, 'compare_price' => 99.99, 'stock' => 80, 'featured' => true, 'category' => 1],
            ['name' => 'Leather Jacket', 'price' => 199.99, 'compare_price' => 249.99, 'stock' => 30, 'featured' => false, 'category' => 1],
            ['name' => 'Running Sneakers', 'price' => 89.99, 'compare_price' => 119.99, 'stock' => 60, 'featured' => true, 'category' => 1],
            // Books
            ['name' => 'The Pragmatic Programmer', 'price' => 49.99, 'compare_price' => 59.99, 'stock' => 200, 'featured' => false, 'category' => 2],
            ['name' => 'Clean Code', 'price' => 44.99, 'compare_price' => 54.99, 'stock' => 150, 'featured' => false, 'category' => 2],
            ['name' => 'Design Patterns', 'price' => 54.99, 'compare_price' => null, 'stock' => 120, 'featured' => false, 'category' => 2],
            // Home & Garden
            ['name' => 'Instant Pot Pro', 'price' => 129.99, 'compare_price' => 159.99, 'stock' => 45, 'featured' => true, 'category' => 3],
            ['name' => 'Smart LED Strip Lights', 'price' => 39.99, 'compare_price' => 49.99, 'stock' => 90, 'featured' => false, 'category' => 3],
            ['name' => 'Robot Vacuum Cleaner', 'price' => 299.99, 'compare_price' => 399.99, 'stock' => 20, 'featured' => true, 'category' => 3],
            // Sports
            ['name' => 'Yoga Mat Premium', 'price' => 59.99, 'compare_price' => 79.99, 'stock' => 75, 'featured' => false, 'category' => 4],
            ['name' => 'Adjustable Dumbbells Set', 'price' => 249.99, 'compare_price' => 299.99, 'stock' => 30, 'featured' => true, 'category' => 4],
            ['name' => 'Running Water Bottle', 'price' => 24.99, 'compare_price' => null, 'stock' => 200, 'featured' => false, 'category' => 4],
            // Beauty
            ['name' => 'Vitamin C Serum', 'price' => 34.99, 'compare_price' => 44.99, 'stock' => 100, 'featured' => false, 'category' => 5],
            ['name' => 'Hair Care Bundle', 'price' => 79.99, 'compare_price' => 99.99, 'stock' => 60, 'featured' => true, 'category' => 5],
        ];

        $products = [];
        $descriptions = [
            'This premium product offers exceptional quality and performance. Designed for those who demand the best, it combines cutting-edge technology with elegant design. Perfect for everyday use, it delivers outstanding results every time. Built to last with premium materials and expert craftsmanship.',
        ];

        foreach ($productsData as $data) {
            $products[] = Product::create([
                'category_id' => $categories[$data['category']]->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $descriptions[0],
                'short_description' => "Premium quality {$data['name']} - best in class performance and design.",
                'price' => $data['price'],
                'compare_price' => $data['compare_price'],
                'stock' => $data['stock'],
                'sku' => 'SKU-' . strtoupper(Str::random(8)),
                'is_active' => true,
                'is_featured' => $data['featured'],
                'average_rating' => round(rand(35, 50) / 10, 1),
                'reviews_count' => rand(5, 50),
            ]);
        }

        // Create some orders
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'delivered', 'delivered'];
        foreach ($users as $user) {
            $numOrders = rand(1, 3);
            for ($o = 0; $o < $numOrders; $o++) {
                $orderProducts = array_rand($products, rand(1, 3));
                if (!is_array($orderProducts)) {
                    $orderProducts = [$orderProducts];
                }

                $subtotal = 0;
                $items = [];
                foreach ($orderProducts as $pi) {
                    $qty = rand(1, 3);
                    $price = $products[$pi]->price;
                    $items[] = ['product' => $products[$pi], 'qty' => $qty, 'price' => $price];
                    $subtotal += $qty * $price;
                }

                $tax = round($subtotal * 0.08, 2);
                $shipping = $subtotal >= 100 ? 0 : 9.99;
                $total = $subtotal + $tax + $shipping;

                $order = Order::create([
                    'user_id' => $user->id,
                    'order_number' => Order::generateOrderNumber(),
                    'status' => $statuses[array_rand($statuses)],
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping' => $shipping,
                    'total' => $total,
                    'first_name' => explode(' ', $user->name)[0],
                    'last_name' => explode(' ', $user->name)[1] ?? 'Doe',
                    'email' => $user->email,
                    'phone' => '+1 555-' . rand(100, 999) . '-' . rand(1000, 9999),
                    'address' => rand(100, 9999) . ' Main Street',
                    'city' => 'New York',
                    'state' => 'NY',
                    'zip_code' => '10001',
                    'country' => 'US',
                    'payment_method' => 'cod',
                    'payment_status' => 'pending',
                    'created_at' => now()->subDays(rand(1, 90)),
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'product_name' => $item['product']->name,
                        'product_image' => $item['product']->image,
                        'quantity' => $item['qty'],
                        'price' => $item['price'],
                        'total' => $item['qty'] * $item['price'],
                    ]);
                }
            }
        }

        // Add some reviews
        $reviewTitles = ['Excellent product!', 'Very satisfied', 'Great quality', 'Highly recommend', 'Worth every penny'];
        $reviewBodies = [
            'This product exceeded my expectations. The quality is outstanding and it works perfectly.',
            'I am very happy with this purchase. Delivery was fast and the item is exactly as described.',
            'Great value for money. Would definitely buy again and recommend to friends.',
        ];

        foreach ($users as $user) {
            $reviewProducts = array_rand($products, rand(2, 5));
            if (!is_array($reviewProducts)) $reviewProducts = [$reviewProducts];
            foreach ($reviewProducts as $pi) {
                ProductReview::create([
                    'product_id' => $products[$pi]->id,
                    'user_id' => $user->id,
                    'rating' => rand(3, 5),
                    'title' => $reviewTitles[array_rand($reviewTitles)],
                    'body' => $reviewBodies[array_rand($reviewBodies)],
                    'is_approved' => true,
                ]);
            }
        }
    }
}
