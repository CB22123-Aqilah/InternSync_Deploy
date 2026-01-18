@extends('layouts.auth-split')

@section('title', 'Login | InternSync')

@section('content')
<div class="auth-card shadow-lg p-5">
    <h3 class="fw-bold mb-2 text-center">Welcome Back</h3>
    <p class="text-center text-muted mb-4">
        Login to continue using <span class="fw-semibold">InternSync</span>
    </p>

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg" placeholder="your@email.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="Your password" required>
        </div>
        <button type="submit" class="btn btn-auth btn-lg w-100 mt-3">Login</button>
    </form>

    <p class="text-center mt-4 small">
        Don’t have an account?
        <a href="{{ route('register') }}" class="auth-link fw-semibold">Register here</a>
    </p>
</div>
@endsection
