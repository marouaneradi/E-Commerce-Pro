@extends('layouts.app')

@section('title', 'Shop - All Products')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-current">Shop</span>
            @if(request('search'))
                <span class="breadcrumb-sep">›</span>
                <span class="breadcrumb-current">Search: "{{ request('search') }}"</span>
            @endif
        </div>
        <h1>{{ request('search') ? 'Search Results' : (request('category') ? ucfirst(str_replace('-', ' ', request('category'))) : 'All Products') }}</h1>
        <p>{{ $products->total() }} products found</p>
    </div>
</div>

<div class="container">
    <div class="shop-layout">
        {{-- Sidebar --}}
        <aside class="filter-sidebar">
            <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div class="filter-group">
                    <div class="filter-title">Categories</div>
                    @foreach($categories as $cat)
                    <label>
                        <input type="radio" name="category" value="{{ $cat->slug }}"
                            {{ request('category') === $cat->slug ? 'checked' : '' }}
                            onchange="document.getElementById('filterForm').submit()">
                        {{ $cat->name }}
                        <span style="margin-left:auto;color:var(--text-muted);font-size:.75rem;">({{ $cat->active_products_count }})</span>
                    </label>
                    @endforeach
                    @if(request('category'))
                        <a href="{{ route('products.index', array_except(request()->query(), 'category')) }}" class="btn btn-ghost btn-sm" style="margin-top:.5rem;font-size:.8rem;">✕ Clear Category</a>
                    @endif
                </div>

                <div class="filter-group">
                    <div class="filter-title">Price Range</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                        <div>
                            <label class="form-label" style="font-size:.75rem;">Min</label>
                            <input type="number" name="min_price" class="form-control form-control-sm" placeholder="$0" value="{{ request('min_price') }}" style="padding:.5rem;">
                        </div>
                        <div>
                            <label class="form-label" style="font-size:.75rem;">Max</label>
                            <input type="number" name="max_price" class="form-control form-control-sm" placeholder="$999" value="{{ request('max_price') }}" style="padding:.5rem;">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm btn-block" style="margin-top:.75rem;">Apply Filter</button>
                </div>

                <div class="filter-group">
                    <div class="filter-title">Sort By</div>
                    <div style="display:flex;flex-direction:column;gap:.5rem;">
                        @foreach(['latest' => 'Newest First', 'price_asc' => 'Price: Low to High', 'price_desc' => 'Price: High to Low', 'rating' => 'Top Rated', 'name_asc' => 'Name A-Z'] as $value => $label)
                        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem;">
                            <input type="radio" name="sort" value="{{ $value }}"
                                {{ request('sort', 'latest') === $value ? 'checked' : '' }}
                                onchange="document.getElementById('filterForm').submit()">
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

                @if(request()->hasAny(['category', 'min_price', 'max_price', 'sort', 'search']))
                    <a href="{{ route('products.index') }}" class="btn btn-ghost btn-sm btn-block">✕ Clear All Filters</a>
                @endif
            </form>
        </aside>

        {{-- Products --}}
        <div>
            @if($products->isEmpty())
                <div class="empty-state card">
                    <div class="card-body">
                        <div class="empty-state-icon">📦</div>
                        <h3>No products found</h3>
                        <p>Try adjusting your filters or search terms.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Browse All Products</a>
                    </div>
                </div>
            @else
                <div class="products-grid">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="pagination">
                    {{ $products->links('partials.pagination') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
