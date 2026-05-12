<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPESDA Medini - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f3fdf8; }
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="text-gray-800 antialiased min-h-screen flex flex-col bg-gradient-to-br from-[#f3fdf8] to-[#e6f9f0]">
    <div class="min-h-screen flex flex-col relative overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-green-50 to-transparent -z-10"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-green-200 opacity-20 blur-3xl -z-10"></div>
        <div class="absolute top-40 -left-40 w-96 h-96 rounded-full bg-emerald-200 opacity-20 blur-3xl -z-10"></div>

        @auth
        <!-- Navbar -->
        <nav class="glass sticky top-0 z-50 shadow-sm border-b border-green-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-green-600 to-emerald-400 flex items-center justify-center text-white shadow-lg shadow-green-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex-shrink-0 font-bold text-2xl tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-green-700 to-emerald-600">
                            SIPESDA MEDINI
                        </div>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold border border-green-200">
                                {{ substr(Auth::user()->nama, 0, 1) }}
                            </div>
                            <div class="hidden md:flex flex-col">
                                <span class="text-sm font-semibold text-gray-800 leading-tight">{{ Auth::user()->nama }}</span>
                                <span class="text-xs text-green-600 font-medium tracking-wide uppercase">{{ Auth::user()->role }}</span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="group flex items-center gap-2 bg-white border border-gray-200 hover:border-red-200 hover:bg-red-50 text-gray-600 hover:text-red-600 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300">
                                Logout
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        @endauth

        <!-- Main Content -->
        <main class="flex-grow max-w-7xl w-full mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="mt-auto border-t border-green-100/50 bg-white/50 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <p class="text-sm text-gray-500 font-medium">
                    &copy; {{ date('Y') }} SIPESDA Medini. All rights reserved.
                </p>
                <div class="flex gap-4">
                    <span class="text-xs text-gray-400">Ver. 1.0.0</span>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
