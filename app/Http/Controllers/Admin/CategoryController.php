<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $request->get('sort_order', 0);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully!');
    }
}
