@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')
<div class="admin-page-header">
    <h1 class="admin-page-title">+ New Category</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">← Back</a>
</div>

<div style="max-width:600px;">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($errors->any())
            <div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        <div class="admin-form-section">
            <div class="admin-form-section-header">Category Information</div>
            <div class="admin-form-section-body">
                <div class="form-group">
                    <label class="form-label">Category Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <label class="toggle-wrap" style="margin-top:.75rem;">
                            <div class="toggle">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </div>
                            <span class="toggle-label">Active</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Category Image</label>
                    <div class="file-upload">
                        <input type="file" name="image" accept="image/*" data-preview="imgPreview">
                        <div class="file-upload-icon">🖼️</div>
                        <p><span>Click to upload</span></p>
                    </div>
                    <img id="imgPreview" style="display:none;margin-top:.75rem;" class="image-preview-lg" alt="">
                    @error('image')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn btn-primary">Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
