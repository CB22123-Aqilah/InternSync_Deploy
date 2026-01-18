@extends('layouts.auth-split')

@section('title', 'Register | InternSync')

@section('content')
<div class="auth-card shadow-lg p-5">
    <h3 class="fw-bold mb-2 text-center">Student Registration</h3>
    <p class="text-center text-muted mb-4 small">
        Please fill in your details to create an InternSync account
    </p>

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf

        <h6 class="text-info fw-semibold mb-3">Account Information</h6>
        <div class="mb-3">
            <label class="form-label fw-semibold">Full Name</label>
            <input type="text" name="name" class="form-control form-control-lg" placeholder="e.g. Nur Aqilah Ahmad" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg" placeholder="student@umpsa.edu.my" required>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="Minimum 6 characters" required>
        </div>

        <h6 class="text-info fw-semibold mb-3">Student Profile</h6>
        <div class="mb-3">
            <label class="form-label fw-semibold">Phone Number</label>
            <input type="text" name="phone" class="form-control form-control-lg" placeholder="e.g. 0123456789" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Programme</label>
            <input type="text" name="programme" class="form-control form-control-lg" placeholder="e.g. Software Engineering" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">CGPA</label>
                <input type="number" step="0.01" min="0" max="4" name="cgpa" class="form-control form-control-lg" placeholder="0.00 – 4.00" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Year of Study</label>
                <input type="number" min="1" max="5" name="year_of_study" class="form-control form-control-lg" placeholder="e.g. 2" required>
            </div>
        </div>

        <input type="hidden" name="role" value="student">

        <button type="submit" class="btn btn-auth btn-lg w-100 mt-3">Create Account</button>
    </form>

    <div class="text-center mt-4 small">
        Already have an account? <br>
        <a href="{{ route('login') }}" class="auth-link fw-semibold">Login here</a>
    </div>
</div>
@endsection
