<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total');

        return view('user.dashboard', compact('user', 'recentOrders', 'totalOrders', 'totalSpent'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }

    public function orderDetail(string $orderNumber)
    {
        $order = Order::with('items')
            ->where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('user.order-detail', compact('order'));
    }

    public function settings()
    {
        $user = auth()->user();
        return view('user.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'phone', 'address']);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully!');
    }
}
