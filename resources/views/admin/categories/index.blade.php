@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">🏷️ Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Add Category</a>
</div>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Products</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            @if($category->image)
                                <img src="{{ $category->image_url }}" style="width:40px;height:40px;border-radius:var(--radius-sm);object-fit:cover;border:1px solid var(--border);" alt="">
                            @else
                                <div style="width:40px;height:40px;border-radius:var(--radius-sm);background:rgba(99,102,241,.1);display:flex;align-items:center;justify-content:center;font-size:1.25rem;">🏷️</div>
                            @endif
                            <strong>{{ $category->name }}</strong>
                        </div>
                    </td>
                    <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text-muted);">{{ $category->description ?? '—' }}</td>
                    <td>{{ $category->products_count ?? 0 }}</td>
                    <td>{{ $category->sort_order }}</td>
                    <td>
                        <span class="status-badge" style="background:{{ $category->is_active ? '#d1fae5' : '#fee2e2' }};color:{{ $category->is_active ? '#065f46' : '#991b1b' }};">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.375rem;">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline btn-sm">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" data-confirm="Delete this category?">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--text-muted);">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="pagination">{{ $categories->links('partials.pagination') }}</div>
    </div>
</div>
@endsection
