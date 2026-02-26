@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="auth-card">
    <div class="auth-logo">
        <div class="logo">🛒 ECommerce Pro</div>
    </div>
    <h2 class="auth-title">Reset Password</h2>
    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="form-group">
            <label class="form-label">Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">New Password <span class="required">*</span></label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Confirm Password <span class="required">*</span></label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-lg">Reset Password</button>
    </form>
</div>
@endsection
