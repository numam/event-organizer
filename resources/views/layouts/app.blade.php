<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Premium Events')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#7c3aed', // purple-700
                    }
                }
            }
        }
    </script>

    {{-- Auth token exposed to JS (if present in session) --}}
    <script>
        window.AUTH_TOKEN = @json(session('auth_token') ?? null);
    </script>

    <style>
        @keyframes backgroundShift {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-5%, -5%) rotate(180deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .bg-animated::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(124, 58, 237, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(79, 70, 229, 0.06) 0%, transparent 50%);
            animation: backgroundShift 20s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        .logo-gradient {
            background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link-hover::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .nav-link-hover:hover::before {
            opacity: 0.15;
        }

        .nav-link-active::after {
            content: '';
            position: absolute;
            bottom: 0.375rem;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #7c3aed;
            box-shadow: 0 0 8px #7c3aed;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #faf9fc;
        }

        ::-webkit-scrollbar-thumb {
            background: #d8b4fe;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #7c3aed;
        }
    </style>
</head>
<body class="font-primary bg-gradient-to-br from-[#faf9fc] via-white to-[#f3f0fa] text-gray-900 min-h-screen overflow-x-hidden bg-animated">
    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- Modern Glassmorphic Topbar -->
        <nav class="sticky top-0 z-50 flex items-center justify-between px-6 md:px-12 py-5 bg-white/80 backdrop-blur-xl border-b border-purple-100/50 shadow-sm transition-all duration-300" id="topbar">
            <!-- Logo -->
            <div class="text-2xl font-extrabold tracking-tight cursor-pointer transition-transform duration-300 hover:scale-105 logo-gradient">
                Event<span class="text-purple-700">Pro</span>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="md:hidden flex flex-col gap-1.5 p-2 rounded-lg hover:bg-purple-50 transition-colors" id="menuToggle">
                <span class="w-6 h-0.5 bg-gray-700 rounded-full transition-all duration-300"></span>
                <span class="w-6 h-0.5 bg-gray-700 rounded-full transition-all duration-300"></span>
                <span class="w-6 h-0.5 bg-gray-700 rounded-full transition-all duration-300"></span>
            </button>

            <!-- Navigation Menu -->
            <ul class="hidden md:flex items-center gap-2 list-none" id="navMenu">
                <li class="relative">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link-hover relative block px-5 py-2.5 rounded-xl text-sm font-medium tracking-wide transition-all duration-300 hover:text-purple-700 hover:-translate-y-0.5 {{ request()->routeIs('dashboard') ? 'text-purple-700 bg-purple-50 shadow-[0_0_0_1px_rgba(124,58,237,0.2)] nav-link-active' : 'text-gray-600' }}">
                        Dashboard
                    </a>
                </li>
                <li class="relative">
                    <a href="{{ route('venues.index') }}"
                       class="nav-link-hover relative block px-5 py-2.5 rounded-xl text-sm font-medium tracking-wide transition-all duration-300 hover:text-purple-700 hover:-translate-y-0.5 {{ request()->routeIs('venues.*') ? 'text-purple-700 bg-purple-50 shadow-[0_0_0_1px_rgba(124,58,237,0.2)] nav-link-active' : 'text-gray-600' }}">
                        Venues
                    </a>
                </li>
                <li class="relative">
                    <a href="{{ route('events.index') }}"
                       class="nav-link-hover relative block px-5 py-2.5 rounded-xl text-sm font-medium tracking-wide transition-all duration-300 hover:text-purple-700 hover:-translate-y-0.5 {{ request()->routeIs('events.*') ? 'text-purple-700 bg-purple-50 shadow-[0_0_0_1px_rgba(124,58,237,0.2)] nav-link-active' : 'text-gray-600' }}">
                        Events
                    </a>
                </li>
                <li class="relative">
                    <button
                        id="logoutBtn"
                        class="inline-flex items-center rounded-lg bg-black px-6 py-2.5 text-sm font-medium text-white hover:bg-gray-800 transition"
                    >
                        Logout
                    </button>
                </li>
            </ul>

            <!-- Mobile Menu -->
            <ul class="absolute top-full left-0 right-0 flex-col gap-0 list-none bg-white/98 backdrop-blur-xl border-b border-purple-100/50 shadow-lg p-4 -translate-y-full opacity-0 pointer-events-none transition-all duration-400 md:hidden" id="mobileMenu">
                <li class="w-full">
                    <a href="{{ route('dashboard') }}"
                       class="block w-full px-4 py-3.5 rounded-lg text-sm font-medium transition-all duration-300 hover:bg-purple-50 {{ request()->routeIs('dashboard') ? 'text-purple-700 bg-purple-50' : 'text-gray-600' }}">
                        Dashboard
                    </a>
                </li>
                <li class="w-full">
                    <a href="{{ route('venues.index') }}"
                       class="block w-full px-4 py-3.5 rounded-lg text-sm font-medium transition-all duration-300 hover:bg-purple-50 {{ request()->routeIs('venues.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600' }}">
                        Venues
                    </a>
                </li>
                <li class="w-full">
                    <a href="{{ route('events.index') }}"
                       class="block w-full px-4 py-3.5 rounded-lg text-sm font-medium transition-all duration-300 hover:bg-purple-50 {{ request()->routeIs('events.*') ? 'text-purple-700 bg-purple-50' : 'text-gray-600' }}">
                        Events
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 px-6 md:px-12 py-12 md:py-16 max-w-7xl mx-auto w-full animate-fade-in">
            @yield('content')
        </main>
    </div>

    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        menuToggle.addEventListener('click', () => {
            const spans = menuToggle.querySelectorAll('span');
            const isActive = mobileMenu.classList.contains('translate-y-0');

            if (isActive) {
                // Close menu
                mobileMenu.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
                mobileMenu.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
                spans[0].classList.remove('rotate-45', 'translate-y-2');
                spans[1].classList.remove('opacity-0');
                spans[2].classList.remove('-rotate-45', '-translate-y-2');
            } else {
                // Open menu
                mobileMenu.classList.remove('-translate-y-full', 'opacity-0', 'pointer-events-none');
                mobileMenu.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
                spans[0].classList.add('rotate-45', 'translate-y-2');
                spans[1].classList.add('opacity-0');
                spans[2].classList.add('-rotate-45', '-translate-y-2');
            }
        });

        // Topbar scroll effect
        let lastScrollTop = 0;
        const topbar = document.getElementById('topbar');

        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 20) {
                topbar.classList.add('py-3.5', 'shadow-lg');
                topbar.classList.remove('py-5');
            } else {
                topbar.classList.add('py-5');
                topbar.classList.remove('py-3.5', 'shadow-lg');
            }

            lastScrollTop = scrollTop;
        });

        // Close mobile menu on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                const spans = menuToggle.querySelectorAll('span');
                mobileMenu.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
                mobileMenu.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
                spans[0].classList.remove('rotate-45', 'translate-y-2');
                spans[1].classList.remove('opacity-0');
                spans[2].classList.remove('-rotate-45', '-translate-y-2');
            }
        });
    </script>
