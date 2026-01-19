@extends('layouts.auth-split')

@section('title', 'Login | InternSync')

@section('content')
<div class="auth-card shadow-lg p-5">
    <h3 class="fw-bold mb-2 text-center">Welcome Back</h3>
    <p class="text-center text-muted mb-4">
        Login to continue using <span class="fw-semibold">InternSync</span>
    </p>

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-4 px-4 py-3 rounded-4
                    d-flex gap-3 align-items-center
                    shadow-sm"
            style="
                background: rgba(220,53,69,0.08);
                border-left: 4px solid #dc3545;
            ">

            <div class="fs-4">❌</div>

            <div class="small text-danger fw-semibold">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-4
                    d-flex gap-3 align-items-center
                    shadow-sm"
            style="
                background: rgba(25,135,84,0.08);
                border-left: 4px solid #198754;
            ">

            <div class="fs-4">✅</div>

            <div class="small text-success fw-semibold">
                {{ session('success') }}
            </div>
        </div>
    @endif

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
