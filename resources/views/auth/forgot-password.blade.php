@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo">🛒 ECommerce Pro</div>
        <p>Reset your password</p>
    </div>

    <h2 class="auth-title">Forgot Password?</h2>
    <p class="auth-subtitle">Enter your email and we'll send a reset link.</p>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email Address <span class="required">*</span></label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-lg">Send Reset Link</button>
    </form>

    <div class="auth-footer">
        <a href="{{ route('login') }}">← Back to Login</a>
    </div>
</div>
@endsection
