<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'InternSync')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind extensions -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    borderRadius: { 'xl-2': '1rem' },
                    boxShadow: {
                        'soft-lg': '0 10px 30px rgba(2,6,23,0.08)',
                        'card': '0 6px 18px rgba(11,15,30,0.06)'
                    }
                }
            }
        }
    </script>

    <!-- Role-based palette -->
    @php
        $role = session('role', 'guest');
        $palettes = [
            'student' => [
                'primary' => '#7dd3fc',
                'primaryDark' => '#38bdf8',
                'accent' => '#fef08a',
                'bg' => 'linear-gradient(180deg, #cbdcf3ff 30%, #ffffff 75%)'
            ],
            'coordinator' => [
                'primary' => '#e9d5ff',
                'primaryDark' => '#c084fc',
                'accent' => '#fde68a',
                'bg' => 'linear-gradient(180deg, #e5d4f6ff 30%, #ffffff 75%)'
            ],
            'admin' => [
                'primary' => '#ffd6c7',
                'primaryDark' => '#ff9a8b',
                'accent' => '#ffe4b5',
                'bg' => 'linear-gradient(180deg, #ffc3c7ff 30%, #ffffff 75%)'
            ],
            'guest' => [
                'primary' => '#ebf9b7',
                'primaryDark' => '#ebfc57',
                'accent' => '#b3fb9e',
                'bg' => 'linear-gradient(180deg, #ebffab 30%, #ffffff 75%)'
            ],
        ];
        $palette = $palettes[$role] ?? $palettes['guest'];
    @endphp

    <style>
        :root{
            --is-primary: {{ $palette['primary'] }};
            --is-primary-dark: {{ $palette['primaryDark'] }};
            --is-accent: {{ $palette['accent'] }};
            --is-bg: {{ $palette['bg'] }};
        }

        html, body {
            height: auto; /* allow scrolling */
            min-height: 100%;
            overflow-x: hidden;
        }

        main {
            min-height: 100vh;
            background: transparent; /* let body gradient show */
        }

        /* When sidebar is open */
        .main-shift {
            transform: translateX(8rem); /* same as w-64 */
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background: var(--is-bg);
            background-attachment: scroll;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
            color: #0f172a;
        }

        .is-navbar { background: linear-gradient(90deg, var(--is-primary), var(--is-primary-dark)); color: #021025; }
        .is-navbar .brand { color: #022c40; }

        .is-sidenav {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(6px);
            border-right: 1px solid rgba(2,6,23,0.06);
            transition: transform 0.3s ease;
            z-index: 40;
        }
        .is-sidenav .nav-link { 
            color: #0b1220; 
            margin-bottom: 4px;
        }
        .is-sidenav .nav-link:hover { background: linear-gradient(90deg, rgba(255,255,255,0.66), rgba(255,255,255,0.9)); color: var(--is-primary-dark); }

        .card {
            background: white;
            border-radius: 14px;
            box-shadow: var(--tw-shadow, 0 8px 30px rgba(2,6,23,0.06));
            border: 1px solid rgba(11,15,30,0.03);
        }

        .btn-accent { background: var(--is-accent); color: #0b1220; }
        .btn-accent:hover { filter: brightness(0.98); }

        .muted { color: #475569; }
        .soft-text { color: #475569; }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); position: fixed; z-index: 50; top: 5rem; height: calc(100% - 5rem); }
            #sidebar.show { transform: translateX(0); }
        }

    </style>
</head>
<body class="min-h-screen">

    <!-- NAVBAR -->
    <nav class="is-navbar fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- Hamburger -->
                <button id="sidebarToggle" class="p-2 rounded bg-white/70 hover:bg-white/90 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <img src="{{ asset('assets/img/PSM Logo.png') }}" alt="logo" class="w-20 h-10">
                <div class="leading-tight">
                    <div class="brand text-lg font-semibold">UMPSA InternSync</div>
                    <div class="text-xs soft-text">Student Internship Recommendation & Tracking</div>
                </div>
            </div>

            @php
                $user = session('firebase_user', []);
                $name = $user['name'] ?? $user['displayName'] ?? 'Guest';
                $email = $user['email'] ?? '';
                $emailLabel = $email ? "({$email})" : '';
            @endphp

            <div class="flex items-center gap-4">
                <div class="text-sm text-slate-800">
                    <div class="font-medium">{{ $name }}</div>
                    <div class="text-xs muted">{{ $emailLabel }}</div>
                </div>
                @if($role !== 'guest')
                <a href="{{ route('logout') }}" class="btn-accent px-4 py-2 rounded-md font-semibold shadow-sm">
                    Logout
                </a>
                @endif
            </div>
        </div>
        @if($role !== 'guest')
        <aside id="sidebar"
               class="is-sidenav fixed top-20 left-0 h-[calc(100vh-5rem)] w-64 p-4 -translate-x-full transition-transform duration-300">
            <div class="text-xs soft-text">
                Internship Recommendation & Monitoring System
            </div>

            <nav class="px-2 flex flex-col gap-1">
                @if($role === 'student')
                    <a href="{{ route('student.dashboard') }}" class="nav-link px-3 py-2 rounded-lg">🏠 Dashboard</a>
                    <a href="{{ route('profile.index') }}" class="nav-link px-3 py-2 rounded-lg">📄 Profile</a>
                    <a href="{{ route('assessments.index') }}" class="nav-link px-3 py-2 rounded-lg">👩‍💼 Personality Test</a>
                    <a href="{{ route('recommendations.index') }}" class="nav-link px-3 py-2 rounded-lg">📋 Internship Opportunities</a>
                    <a href="{{ route('guidelines.index') }}" class="nav-link px-3 py-2 rounded-lg">📘 Guidelines</a>
                @endif

                @if($role === 'coordinator')
                    <a href="{{ route('coordinator.dashboard') }}" class="nav-link px-3 py-2 rounded-lg">🏠 Dashboard</a>
                    <a href="{{ route('coordinator.students') }}" class="nav-link px-3 py-2 rounded-lg">📄 View Student Profiles</a>
                    <a href="{{ route('personality.index') }}" class="nav-link px-3 py-2 rounded-lg">👩‍💼 Manage Personality Test</a>
                    <a href="{{ route('recommendations.index') }}" class="nav-link px-3 py-2 rounded-lg">📋 Internship Opportunities</a>
                    <a href="{{ route('guidelines.index') }}" class="nav-link px-3 py-2 rounded-lg">📘 Guidelines</a>
                @endif

                @if($role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link px-3 py-2 rounded-lg">🏠 Dashboard</a>
                    <a href="{{ route('admin.students') }}" class="nav-link px-3 py-2 rounded-lg">📄 View Student Profiles</a>
                    <a href="{{ route('personality.index') }}" class="nav-link px-3 py-2 rounded-lg">👩‍💼 Manage Personality Test</a>
                    <a href="{{ route('recommendations.index') }}" class="nav-link px-3 py-2 rounded-lg">📋 Internship Opportunities</a>
                    <a href="{{ route('guidelines.index') }}" class="nav-link px-3 py-2 rounded-lg">📘 Guidelines</a>
                @endif
            </nav>
        </aside>
        @endif
    </nav>

    <!-- MAIN -->
    <main id="mainContent"
      class="flex-1 p-6 max-w-screen-xl mx-auto pt-28 transition-all duration-300">
        <div class="">
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const main = document.querySelector('main');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            main.classList.toggle('main-shift');
        });
    </script>

</body>
</html>
