<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    const CART_KEY = 'shopping_cart';

    public function getCart(): array
    {
        return Session::get(self::CART_KEY, []);
    }

    public function addItem(int $productId, int $quantity = 1): array
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            $newQty = $cart[$productId]['quantity'] + $quantity;
            $cart[$productId]['quantity'] = min($newQty, $product->stock);
            $cart[$productId]['total'] = $cart[$productId]['price'] * $cart[$productId]['quantity'];
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => min($quantity, $product->stock),
                'image' => $product->image,
                'slug' => $product->slug,
                'total' => (float) $product->price * min($quantity, $product->stock),
            ];
        }

        Session::put(self::CART_KEY, $cart);
        return $cart;
    }

    public function removeItem(int $productId): array
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        Session::put(self::CART_KEY, $cart);
        return $cart;
    }

    public function updateQuantity(int $productId, int $quantity): array
    {
        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            $product = Product::find($productId);
            if ($product) {
                $qty = min($quantity, $product->stock);
                if ($qty <= 0) {
                    return $this->removeItem($productId);
                }
                $cart[$productId]['quantity'] = $qty;
                $cart[$productId]['total'] = $cart[$productId]['price'] * $qty;
                Session::put(self::CART_KEY, $cart);
            }
        }
        return $cart;
    }

    public function clearCart(): void
    {
        Session::forget(self::CART_KEY);
    }

    public function getSubtotal(): float
    {
        return array_sum(array_column($this->getCart(), 'total'));
    }

    public function getTax(float $rate = 0.08): float
    {
        return round($this->getSubtotal() * $rate, 2);
    }

    public function getShipping(): float
    {
        $subtotal = $this->getSubtotal();
        if ($subtotal === 0.0) return 0.0;
        return $subtotal >= 100 ? 0.0 : 9.99;
    }

    public function getTotal(): float
    {
        return $this->getSubtotal() + $this->getTax() + $this->getShipping();
    }

    public function getCount(): int
    {
        return array_sum(array_column($this->getCart(), 'quantity'));
    }

    public function isEmpty(): bool
    {
        return empty($this->getCart());
    }
}
