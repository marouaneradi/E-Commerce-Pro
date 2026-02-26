@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">+ New Product</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">← Back to Products</a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:1rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">
        <div>
            {{-- Basic Info --}}
            <div class="admin-form-section">
                <div class="admin-form-section-header">Basic Information</div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-label">Product Name <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Short Description</label>
                        <input type="text" name="short_description" class="form-control" value="{{ old('short_description') }}" placeholder="Brief product summary">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Full Description <span class="required">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6" required>{{ old('description') }}</textarea>
                        @error('description')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Pricing --}}
            <div class="admin-form-section">
                <div class="admin-form-section-header">Pricing & Inventory</div>
                <div class="admin-form-section-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Sale Price ($) <span class="required">*</span></label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" step="0.01" min="0" required>
                            @error('price')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Compare Price ($)</label>
                            <input type="number" name="compare_price" class="form-control" value="{{ old('compare_price') }}" step="0.01" min="0" placeholder="Original price">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Stock Quantity <span class="required">*</span></label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" min="0" required>
                            @error('stock')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" placeholder="e.g. PROD-001">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="admin-form-section">
                <div class="admin-form-section-header">Status</div>
                <div class="admin-form-section-body">
                    <div class="form-group">
                        <label class="form-label">Category <span class="required">*</span></label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="toggle-wrap">
                            <div class="toggle">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Active (visible in store)</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="toggle-wrap">
                            <div class="toggle">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Featured Product</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="admin-form-section">
                <div class="admin-form-section-header">Product Image</div>
                <div class="admin-form-section-body">
                    <div class="file-upload">
                        <input type="file" name="image" accept="image/*" data-preview="imagePreview">
                        <div class="file-upload-icon">🖼️</div>
                        <p><span>Click to upload</span> or drag & drop</p>
                        <p style="font-size:.75rem;margin-top:.25rem;">JPG, PNG, GIF, WebP (max 2MB)</p>
                    </div>
                    <img id="imagePreview" style="display:none;" class="image-preview-lg" alt="Preview">
                    @error('image')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">Create Product</button>
        </div>
    </div>
</form>
@endsection
