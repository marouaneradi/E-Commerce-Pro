@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">📦 Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="table-toolbar" style="width:100%">
            <form action="{{ route('admin.products.index') }}" method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;">
                <div class="table-search">
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                    <button type="submit">🔍</button>
                </div>
                <select name="category" class="form-control" style="width:auto;" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @if(request()->hasAny(['search', 'category']))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-sm">Clear</a>
                @endif
            </form>
        </div>
    </div>
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            @if($product->image)
                                <img src="{{ $product->image_url }}" class="image-preview" style="width:44px;height:44px;" alt="">
                            @else
                                <div style="width:44px;height:44px;border-radius:var(--radius);background:var(--bg);display:flex;align-items:center;justify-content:center;border:1px solid var(--border);font-size:1rem;">📦</div>
                            @endif
                            <div>
                                <div style="font-weight:600;font-size:.9rem;">{{ $product->name }}</div>
                                @if($product->sku)
                                    <div style="font-size:.75rem;color:var(--text-muted);">{{ $product->sku }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td>
                        ${{ number_format($product->price, 2) }}
                        @if($product->compare_price)
                            <br><small style="text-decoration:line-through;color:var(--text-muted);">${{ number_format($product->compare_price, 2) }}</small>
                        @endif
                    </td>
                    <td>
                        <span style="font-weight:600;color:{{ $product->stock <= 5 ? 'var(--danger)' : ($product->stock <= 20 ? 'var(--warning)' : 'var(--accent)') }};">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge" style="background:{{ $product->is_active ? '#d1fae5' : '#fee2e2' }};color:{{ $product->is_active ? '#065f46' : '#991b1b' }};">
                            {{ $product->is_active ? '✓ Active' : '✗ Inactive' }}
                        </span>
                        @if($product->is_featured)
                            <span class="status-badge" style="background:#fef3c7;color:#92400e;margin-left:.25rem;">⭐ Featured</span>
                        @endif
                    </td>
                    <td>
                        @if($product->reviews_count > 0)
                            ⭐ {{ number_format($product->average_rating, 1) }} ({{ $product->reviews_count }})
                        @else
                            <span style="color:var(--text-muted);">No reviews</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.375rem;">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-ghost btn-sm btn-icon" title="View" target="_blank">👁️</a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" data-confirm="Delete this product?">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:3rem;color:var(--text-muted);">
                        No products found. <a href="{{ route('admin.products.create') }}" style="color:var(--primary);">Add one?</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="pagination">{{ $products->links('partials.pagination') }}</div>
    </div>
</div>
@endsection
