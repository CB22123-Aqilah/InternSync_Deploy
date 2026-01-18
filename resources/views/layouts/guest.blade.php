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
      background: linear-gradient(180deg, #9bd0ffff, #ffd1d1ff);
    }

    .auth-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
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
  </style>
</head>

<body>
  <div class="auth-wrapper">
    @yield('content')
  </div>

  <script src="{{ asset('js/main.js') }}"></script>
  
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.6') }}"></script>
</body>
</html>
