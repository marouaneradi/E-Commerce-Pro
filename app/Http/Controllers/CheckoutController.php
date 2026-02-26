<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cart)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = $this->cart->getCart();
        $subtotal = $this->cart->getSubtotal();
        $tax = $this->cart->getTax();
        $shipping = $this->cart->getShipping();
        $total = $this->cart->getTotal();
        $user = auth()->user();

        return view('checkout.index', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total', 'user'));
    }

    public function store(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,card,paypal',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cartItems = $this->cart->getCart();

        // Verify stock availability
        foreach ($cartItems as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->stock < $item['quantity']) {
                return back()->with('error', "Insufficient stock for: {$item['name']}");
            }
        }

        DB::beginTransaction();
        try {
            $subtotal = $this->cart->getSubtotal();
            $tax = $this->cart->getTax();
            $shipping = $this->cart->getShipping();
            $total = $this->cart->getTotal();

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'country' => $request->country,
                'notes' => $request->notes,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_image' => $item['image'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);

                // Deduct stock
                Product::where('id', $item['id'])->decrement('stock', $item['quantity']);
            }

            DB::commit();
            $this->cart->clearCart();

            return redirect()->route('checkout.confirmation', $order->order_number)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('checkout.confirmation', compact('order'));
    }
}
