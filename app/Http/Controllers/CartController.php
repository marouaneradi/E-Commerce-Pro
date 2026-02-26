<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index()
    {
        $cartItems = $this->cart->getCart();
        $subtotal = $this->cart->getSubtotal();
        $tax = $this->cart->getTax();
        $shipping = $this->cart->getShipping();
        $total = $this->cart->getTotal();

        return view('cart.index', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:100',
        ]);

        $this->cart->addItem($request->product_id, $request->get('quantity', 1));

        return back()->with('success', 'Product added to cart!');
    }

    public function remove(int $productId)
    {
        $this->cart->removeItem($productId);
        return back()->with('success', 'Item removed from cart.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
        ]);

        $this->cart->updateQuantity($request->product_id, $request->quantity);

        return back()->with('success', 'Cart updated.');
    }

    public function clear()
    {
        $this->cart->clearCart();
        return back()->with('success', 'Cart cleared.');
    }
}
