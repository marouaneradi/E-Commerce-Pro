@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">✏️ Edit Product</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">← Back to Products</a>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">
        <div>
            <div class="admin-form-section">
                <div class="admin-form-section-header">Basic Information</div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-label">Product Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Short Description</label>
                        <input type="text" name="short_description" class="form-control" value="{{ old('short_description', $product->short_description) }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Full Description <span class="required">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6" required>{{ old('description', $product->description) }}</textarea>
                        @error('description')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-header">Pricing & Inventory</div>
                <div class="admin-form-section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Sale Price ($) <span class="required">*</span></label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                            @error('price')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Compare Price ($)</label>
                            <input type="number" name="compare_price" class="form-control" value="{{ old('compare_price', $product->compare_price) }}" step="0.01" min="0">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Stock <span class="required">*</span></label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" min="0" required>
                            @error('stock')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="admin-form-section">
                <div class="admin-form-section-header">Status</div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-label">Category <span class="required">*</span></label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="toggle-wrap">
                            <div class="toggle">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Active</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="toggle-wrap">
                            <div class="toggle">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Featured</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-header">Product Image</div>
                <div class="admin-form-section-body">
                    @if($product->image)
                        <img src="{{ $product->image_url }}" class="image-preview-lg" id="imagePreview" alt="{{ $product->name }}" style="display:block;">
                    @else
                        <img id="imagePreview" style="display:none;" class="image-preview-lg" alt="">
                    @endif
                    <div class="file-upload" style="margin-top:.75rem;">
                        <input type="file" name="image" accept="image/*" data-preview="imagePreview">
                        <div class="file-upload-icon">🖼️</div>
                        <p><span>{{ $product->image ? 'Replace image' : 'Upload image' }}</span></p>
                        <p style="font-size:.75rem;margin-top:.25rem;">JPG, PNG, GIF, WebP (max 2MB)</p>
                    </div>
                    @error('image')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-block" style="margin-top:.5rem;">Cancel</a>
        </div>
    </div>
</form>
@endsection
