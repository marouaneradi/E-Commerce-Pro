@extends('layouts.auth')
@section('title', 'Verify Email')
@section('content')
<div class="auth-card" style="text-align:center;">
    <div style="font-size:3rem;margin-bottom:1rem;">📧</div>
    <h2 class="auth-title">Verify Your Email</h2>
    <p class="auth-subtitle">We've sent a verification link to your email address. Please check your inbox.</p>
    @if(session('status') === 'verification-link-sent')
        <div class="alert alert-success">A new verification link has been sent to your email!</div>
    @endif
    <form method="POST" action="{{ route('verification.send') }}" style="margin-top:1.5rem;">
        @csrf
        <button type="submit" class="btn btn-primary btn-block">Resend Verification Email</button>
    </form>
    <div class="auth-footer">
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:none;border:none;color:var(--primary);font-weight:600;cursor:pointer;">Logout</button>
        </form>
    </div>
</div>
@endsection
