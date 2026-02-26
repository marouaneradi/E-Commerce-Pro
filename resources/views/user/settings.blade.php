@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('user.dashboard') }}">Dashboard</a>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-current">Settings</span>
        </div>
        <h1>⚙️ Account Settings</h1>
    </div>
</div>

<div class="container" style="max-width:700px;">
    {{-- Profile Update --}}
    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header"><h3>👤 Profile Information</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="display:flex;align-items:center;gap:1.5rem;margin-bottom:1.5rem;">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" id="avatarPreview" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid var(--primary);">
                    <div>
                        <label class="btn btn-outline btn-sm" style="cursor:pointer;">
                            📷 Change Photo
                            <input type="file" name="avatar" accept="image/*" style="display:none;" data-preview="avatarPreview">
                        </label>
                        <p style="font-size:.78rem;color:var(--text-muted);margin-top:.375rem;">Max 2MB. JPG, PNG, GIF</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled style="opacity:.6;">
                    <div class="form-hint">Email cannot be changed. Contact support if needed.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="+1 555-123-4567">
                    @error('phone')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Default Address</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="123 Main St, City, State 12345">{{ old('address', $user->address) }}</textarea>
                    @error('address')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="card">
        <div class="card-header"><h3>🔒 Change Password</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.settings.password') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Current Password <span class="required">*</span></label>
                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">New Password <span class="required">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm New Password <span class="required">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
