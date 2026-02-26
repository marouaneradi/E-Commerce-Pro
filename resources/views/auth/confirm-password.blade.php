@extends('layouts.auth')
@section('title', 'Confirm Password')
@section('content')
<div class="auth-card">
    <h2 class="auth-title">Confirm Password</h2>
    <p class="auth-subtitle">Please confirm your password before continuing.</p>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">Confirm</button>
    </form>
</div>
@endsection
