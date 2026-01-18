<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <style>
        body {
            background: #f9fafb;
            font-family: Arial, sans-serif;
            color: #333;
            text-align: center;
            margin-top: 100px;
        }
        a {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>404 | Page Not Found</h1>
    <p>The page you are looking for could not be found.</p>
    <a href="{{ url('/') }}">← Go Back Home</a>
</body>
</html>
