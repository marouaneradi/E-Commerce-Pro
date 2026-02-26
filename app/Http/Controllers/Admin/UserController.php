<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('orders');
        $totalSpent = $user->orders()->whereNotIn('status', ['cancelled'])->sum('total');
        return view('admin.users.show', compact('user', 'totalSpent'));
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own admin status.');
        }
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', 'User role updated.');
    }
}
