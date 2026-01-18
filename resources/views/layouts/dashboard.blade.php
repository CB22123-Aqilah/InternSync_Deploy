<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | InternSync</title>
<script src="https://cdn.tailwindcss.com"></script>
@php
$role = session('role', 'guest');
$colors = [
    'student' => ['primary' => '#10b981', 'primaryDark' => '#059669', 'accent' => '#6ee7b7'],
    'coordinator' => ['primary' => '#4f46e5', 'primaryDark' => '#4338ca', 'accent' => '#a5b4fc'],
    'admin' => ['primary' => '#f59e0b', 'primaryDark' => '#b45309', 'accent' => '#fde68a'],
    'guest' => ['primary' => '#6b7280', 'primaryDark' => '#374151', 'accent' => '#d1d5db']
];
$color = $colors[$role] ?? $colors['guest'];
@endphp

<style>
:root{
    --primary: {{ $color['primary'] }};
    --primary-dark: {{ $color['primaryDark'] }};
    --accent: {{ $color['accent'] }};
}
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    color: #333;
}
header {
    background: rgba(255,255,255,0.95);
    padding: 40px 20px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    border-bottom:1px solid rgba(255,255,255,0.2);
    position: relative;
}
header::before {
    content:'';
    position:absolute;
    top:0; left:0; right:0; height:4px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark), var(--accent));
}
.module-card {
    background: rgba(255,255,255,0.95);
    border-radius: 20px;
    padding:30px 20px;
    text-align:center;
    box-shadow:0 15px 40px rgba(0,0,0,0.1);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.2);
    transition: all 0.3s ease;
}
.module-card:hover { transform:translateY(-5px) scale(1.02); box-shadow:0 25px 60px rgba(0,0,0,0.15);}
.module-card h3 { color: var(--primary-dark); font-size:1.5rem; margin-bottom:15px;}
.module-card p { color: #6b7280; margin-bottom:15px;}
.module-link { display:inline-block; padding:10px 20px; background: var(--primary); color:white; border-radius:50px; font-weight:600; transition: all 0.3s ease;}
.module-link:hover { background: var(--primary-dark); }
</style>
</head>
<body>

<header>
    <div class="text-3xl font-bold mb-2">Welcome, {{ ucfirst($role) }}</div>
    <p class="text-gray-600">Select a module to continue</p>
</header>

<div class="container max-w-7xl mx-auto my-8 px-4">
    <h2 class="text-white text-2xl font-bold mb-6 text-center">Dashboard Modules</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @if($role == 'student')
    <div class="module-card">
        <h3>Manage Profile</h3>
        <p>View, edit, and update your profile and academic performance.</p>
        <a href="{{ route('profile.index') }}" class="module-link">Access Module</a>
    </div>

    <div class="module-card">
        <h3>Internship Guideline</h3>
        <p>View internship guidelines prepared by Admin.</p>
        <a href="{{ route('guidelines.index') }}" class="module-link">Access Module</a>
    </div>

    <div class="module-card">
        <h3>Personality Assessment</h3>
        <p>Take personality assessment to help internship recommendations.</p>
        <a href="{{ route('assessments.start') }}" class="module-link">Access Module</a>
    </div>

    <div class="module-card">
        <h3>Recommendation Internship</h3>
        <p>View recommended internship fields and positions.</p>
        <a href="{{ route('recommendations.index') }}" class="module-link">Access Module</a>
    </div>
@endif

<!-- Coordinator Dashboard -->
@if($role == 'coordinator')
    <div class="module-card">
        <h3>Manage Student Profiles</h3>
        <p>View students' profiles and academic performance.</p>
        <a href="{{ route('coordinator.students') }}" class="module-link">Access Module</a>
    </div>

    <div class="module-card">
        <h3>Recommendation Internship</h3>
        <p>View recommended internship fields and positions.</p>
        <a href="{{ route('recommendations.index') }}" class="module-link">Access Module</a>
    </div>
@endif

<!-- Admin Dashboard -->
@if($role == 'admin')
    <div class="module-card">
        <h3>Manage Internship Guideline</h3>
        <p>Create, edit, or delete internship guidelines for students.</p>
        <a href="{{ route('guidelines.index') }}" class="module-link">Access Module</a>
    </div>

    <div class="module-card">
        <h3>Manage Personality Assessment</h3>
        <p>Create, edit, or delete personality assessment questions.</p>
        <a href="{{ route('personality.index') }}" class="module-link">Access Module</a>
    </div>

    <div class="module-card">
        <h3>Recommendation Dashboard</h3>
        <p>Manage internship field and position information for students.</p>
        <a href="{{ route('recommendations.index') }}" class="module-link">Access Module</a>
    </div>
@endif

    </div>
</div>

<footer class="mt-16 text-center text-white py-6 bg-opacity-20 bg-black">
    © 2025 InternSync | Powered by UMPSA
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>