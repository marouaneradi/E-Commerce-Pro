@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo">🛒 ECommerce Pro</div>
        <p>Welcome back! Sign in to your account.</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email Address <span class="required">*</span></label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;">
                <label class="form-label" for="password" style="margin:0;">Password <span class="required">*</span></label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:.8rem;color:var(--primary);font-weight:600;">Forgot password?</a>
                @endif
            </div>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Your password" required>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group" style="display:flex;align-items:center;gap:.5rem;">
            <input type="checkbox" name="remember" id="remember" style="accent-color:var(--primary);">
            <label for="remember" style="font-size:.875rem;color:var(--text-secondary);cursor:pointer;">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
    </form>

    <div class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}">Create one free</a>
    </div>

    <div style="margin-top:1.5rem;padding:1rem;background:var(--bg);border-radius:var(--radius);border:1px solid var(--border);">
        <p style="font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);margin-bottom:.5rem;">Demo Accounts</p>
        <p style="font-size:.8rem;color:var(--text-secondary);">Admin: <strong>admin@example.com</strong> / password</p>
        <p style="font-size:.8rem;color:var(--text-secondary);">User: <strong>user1@example.com</strong> / password</p>
    </div>
</div>
@endsection
