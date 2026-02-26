@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo">🛒 ECommerce Pro</div>
        <p>Create your free account today</p>
    </div>

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Full Name <span class="required">*</span></label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" placeholder="John Doe" required autofocus>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email Address <span class="required">*</span></label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" placeholder="you@example.com" required>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password <span class="required">*</span></label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="At least 8 characters" required>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password <span class="required">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                placeholder="Repeat password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block btn-lg">Create Account</button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </div>
</div>
@endsection
