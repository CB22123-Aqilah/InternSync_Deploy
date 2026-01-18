<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | InternSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0f2fe, #c7d2fe, #e9d5ff);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            background: white;
            color: #0f172a;
        }

        .btn-custom {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
        }

        h1 {
            font-size: 2.2rem;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="col-md-6 mx-auto">
        <div class="card p-4 text-center">
            <h1 class="mb-4">Welcome to InternSync</h1>
            <p class="text-muted mb-4">
                Smart internship recommendation & tracking platform for UMPSA students
            </p>

            <div class="d-grid gap-3">
                <a href="{{ route('login') }}" class="btn btn-primary btn-custom">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-custom">Register</a>
                <a href="{{ route('guest.form') }}" class="btn btn-outline-success btn-custom">
                Enter as Guest (Industry)
                </a>
            </div>

            <footer class="mt-4 text-muted small">
                © {{ date('Y') }} UMPSA InternSync System
            </footer>
        </div>
    </div>
</div>

</body>
</html>
