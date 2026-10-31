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
            <div class="max-w-7xl mx-auto px-3.5 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">
                    <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-white flex items-center justify-center p-1 shadow-md border border-green-100 shrink-0">
                            @if(file_exists(public_path('images/logo.png')))
                                <img src="{{ asset('images/logo.png') }}" class="w-full h-full object-contain" alt="Logo">
                            @else
                                <div class="w-full h-full rounded-lg bg-gradient-to-tr from-green-600 to-emerald-400 flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="font-bold text-lg sm:text-2xl tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-green-700 to-emerald-600 truncate">
                            SIPESDA MEDINI
                        </div>
                    </div>
                    <!-- Profile Dropdown -->
                    <div class="relative shrink-0" id="profile-dropdown-wrapper">
                        <button type="button" id="profile-menu-button" onclick="toggleProfileDropdown(event)" class="group flex items-center gap-2 sm:gap-2.5 p-1 sm:pr-3 rounded-full hover:bg-green-50/80 border border-transparent hover:border-green-200 transition-all duration-200 focus:outline-none cursor-pointer" aria-expanded="false" aria-haspopup="true">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-gradient-to-tr from-green-600 to-emerald-400 flex items-center justify-center text-white font-bold text-xs sm:text-sm shadow-sm border border-green-200">
                                {{ substr(Auth::user()->nama, 0, 1) }}
                            </div>
                            <div class="hidden md:flex flex-col text-left">
                                <span class="text-xs sm:text-sm font-semibold text-gray-800 leading-tight group-hover:text-green-700 transition">{{ Auth::user()->nama }}</span>
                                <span class="text-[10px] text-green-600 font-bold uppercase tracking-wider">{{ Auth::user()->role }}</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600 transition-transform duration-200" id="profile-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profile-dropdown-menu" class="hidden absolute right-0 mt-2 w-64 sm:w-72 bg-white rounded-2xl shadow-xl border border-gray-150 py-2 z-50 animate-fade-in origin-top-right transition-all">
                            <!-- User Card Header -->
                            <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-green-50/60 to-transparent">
                                <p class="text-[11px] text-gray-400 font-medium">Masuk sebagai</p>
                                <p class="text-sm font-bold text-gray-900 truncate mt-0.5">{{ Auth::user()->nama }}</p>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-green-100 text-green-800">
                                        {{ Auth::user()->role }}
                                    </span>
                                    <span class="text-xs text-gray-400 font-mono truncate">NIK: {{ Auth::user()->nik }}</span>
                                </div>
                            </div>

                            <!-- Menu Links -->
                            <div class="py-1">
                                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs sm:text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition font-medium group">
                                    <div class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-green-100 text-gray-500 group-hover:text-green-700 flex items-center justify-center transition shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold leading-tight">Lihat Profil</p>
                                        <p class="text-[11px] text-gray-400 font-normal">Informasi data kependudukan</p>
                                    </div>
                                </a>

                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs sm:text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition font-medium group">
                                    <div class="w-8 h-8 rounded-xl bg-gray-100 group-hover:bg-green-100 text-gray-500 group-hover:text-green-700 flex items-center justify-center transition shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold leading-tight">Dashboard</p>
                                        <p class="text-[11px] text-gray-400 font-normal">Halaman utama pengajuan</p>
                                    </div>
                                </a>
                            </div>

                            <div class="border-t border-gray-100 my-1"></div>

                            <!-- Logout Button in Dropdown -->
                            <div class="px-2 py-1">
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="button" onclick="confirmLogout(event, this.form)" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs sm:text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition font-semibold group cursor-pointer">
                                        <div class="w-8 h-8 rounded-xl bg-red-50 group-hover:bg-red-100 text-red-500 flex items-center justify-center transition shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-bold leading-tight text-red-600">Logout</p>
                                            <p class="text-[11px] text-red-400 font-normal">Keluar dari sesi akun</p>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @endauth

        <!-- Main Content -->
        <main class="flex-grow max-w-7xl w-full mx-auto py-5 sm:py-8 px-3 sm:px-6 lg:px-8 relative z-10">
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

    @include('components.pdf_preview_modal')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleProfileDropdown(event) {
            if (event) event.stopPropagation();
            const menu = document.getElementById('profile-dropdown-menu');
            const chevron = document.getElementById('profile-chevron');
            if (!menu) return;
            
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        }

        // Close profile dropdown when clicking outside
        document.addEventListener('click', function (e) {
            const wrapper = document.getElementById('profile-dropdown-wrapper');
            const menu = document.getElementById('profile-dropdown-menu');
            const chevron = document.getElementById('profile-chevron');
            if (wrapper && !wrapper.contains(e.target)) {
                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                }
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const menu = document.getElementById('profile-dropdown-menu');
                const chevron = document.getElementById('profile-chevron');
                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                }
            }
        });

        function confirmLogout(event, form) {
            if (event) event.preventDefault();
            const targetForm = form || (event ? event.target.closest('form') : document.getElementById('logout-form'));
            
            Swal.fire({
                title: 'Konfirmasi Keluar',
                text: 'Apakah Anda yakin ingin mengakhiri sesi dan keluar dari sistem?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    confirmButton: 'rounded-xl font-bold px-5 py-2.5 text-sm',
                    cancelButton: 'rounded-xl font-medium px-5 py-2.5 text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed && targetForm) {
                    targetForm.submit();
                }
            });
        }

        // Tangkap juga submit event langsung jika ada form logout lain
        document.addEventListener('DOMContentLoaded', function () {
            const logoutForms = document.querySelectorAll('form[action="{{ route('logout') }}"]');
            logoutForms.forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    if (form.dataset.confirmed !== 'true') {
                        e.preventDefault();
                        confirmLogout(e, form);
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
