<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'InternSync')</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/nucleo-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}">
  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.6') }}" rel="stylesheet" />

  <style>
    body {
      min-height: 100vh;
      margin: 0;
      font-family: 'Inter', system-ui, sans-serif;
      background: linear-gradient(180deg, #9bd0ff, #ffd1d1);
    }

    .auth-split {
      display: flex;
      min-height: 100vh;
      overflow: hidden;
    }

    .auth-split-left {
      display: none;
    }

    .auth-split-right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    .auth-card {
      background: #fff;
      border-radius: 20px;
      padding: 2.5rem 2.2rem;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .auth-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 25px 50px rgba(0,0,0,0.2);
    }

    .auth-card h3 {
      font-weight: 700;
      color: #a46fffff;
      text-align: center;
    }

    .form-control {
      border-radius: 12px;
      padding: 0.75rem 1rem;
      border: 1px solid #e0e0e0;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
      border-color: #a46fffff;
      box-shadow: 0 0 0 3px rgba(164, 111, 255, 0.15);
      outline: none;
    }

    .btn-auth {
      background: #a46fffff;
      border-radius: 50px;
      font-weight: 600;
      padding: 0.75rem 1rem;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-auth:hover {
      background: #9045f7ff;
      transform: translateY(-2px);
    }

    .auth-link {
      color: #a46fffff;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .auth-link:hover {
      color: #9045f7ff;
      text-decoration: underline;
    }

    /* Left panel styles */
    @media (min-width: 768px) {
      .auth-split-left {
        display: flex;
        flex: 1;
        background: linear-gradient(180deg, #9bd0ff, #ffd1d1);
        align-items: center;
        justify-content: flex-start;
        flex-direction: column;
        color: white;
        padding: 7rem;
      }

      .auth-split-left h1 {
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 1rem;
      }

      .auth-split-left p {
        font-size: 1.1rem;
        margin-bottom: 2rem;
      }

      .auth-split-left img {
        max-width: 80%;
      }
    }
    
    /* Logo smaller */
    .auth-logo {
        height: 100px;        /* control size */
        width: auto;         /* keep ratio */
        max-width: 200px;    /* prevent too wide */
        object-fit: contain; /* safety */
    }

    /* Left text */
    .auth-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.3rem;
    }

    .auth-tagline {
    font-size: 0.95rem;
    color: #f5f5f5;
    text-align: center;
    margin-bottom: 1.5rem;
    max-width: 380px;
    }

    /* Button container */
    .auth-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    width: 240px;
    }

    /* Base button (same shape as Login) */
    .auth-btn {
    display: block;
    text-align: center;
    padding: 0.7rem 1rem;
    font-weight: 600;
    border-radius: 999px;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    /* Button colors */
    .auth-btn.primary {
    background: #ffffff;
    color: #7c3aed;
    }

    .auth-btn.primary:hover {
    background: #6d28d9;
    }

    .auth-btn.secondary {
    background: #ffffff;
    color: #7c3aed;
    }

    .auth-btn.secondary:hover {
    background: #f3e8ff;
    }

    .auth-btn.success {
    background: #ffffff;
    color: #7c3aed;
    }

    .auth-btn.success:hover {
    background: #ffffff;
    }

  </style>
</head>
<body>
<div class="auth-split">

    <!-- Left Welcome Panel -->
<!-- Left Welcome Panel -->
<div class="auth-split-left flex flex-col items-center justify-start pt-4 px-4">
    <!-- Logo -->
    <img src="{{ asset('assets/img/PSM Logo.png') }}" 
        alt="InternSync Logo" 
        class="auth-logo mb-2">

    <!-- Heading -->
    <h1 class="auth-title">Welcome to InternSync</h1>

    <!-- Tagline -->
    <p class="auth-tagline">
        Smart internship recommendation & tracking platform for UMPSA students
    </p>

    <!-- Buttons -->
    <div class="auth-actions">
        <a href="{{ route('login') }}" class="auth-btn primary">
            Login
        </a>

        <a href="{{ route('register') }}" class="auth-btn secondary">
            Register
        </a>

        <a href="{{ route('guest.form') }}" class="auth-btn success">
            Enter as Guest (Industry)
        </a>
    </div>
</div>

    <!-- Right Form Panel -->
    <div class="auth-split-right">
        @yield('content')
    </div>

</div>

<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.6') }}"></script>
</body>
</html>
