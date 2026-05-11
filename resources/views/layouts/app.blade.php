<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPESDA Medini - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <div class="min-h-screen flex flex-col">
        @auth
        <!-- Navbar -->
        <nav class="bg-green-700 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 font-bold text-xl tracking-wider">
                            SIPESDA MEDINI
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-4 flex items-center md:ml-6">
                            <span class="mr-4 text-sm font-medium">{{ Auth::user()->nama }} ({{ ucfirst(Auth::user()->role) }})</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-green-800 hover:bg-green-900 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @endauth

        <!-- Main Content -->
        <main class="flex-grow max-w-7xl w-full mx-auto py-6 sm:px-6 lg:px-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} Sistem Informasi Pelayanan Surat Desa Medini. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
