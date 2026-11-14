<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPESDA Staff - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .sidebar-item.active { background: rgba(255,255,255,0.15); border-left: 3px solid #fff; }
        .sidebar-item { border-left: 3px solid transparent; }
    </style>
</head>
<body class="bg-slate-100 text-gray-800 antialiased">

<div class="flex h-screen overflow-hidden relative">

    <!-- Mobile Backdrop -->
    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden transition-opacity"></div>

    <!-- ======== SIDEBAR ======== -->
    <aside id="main-sidebar" class="fixed md:static inset-y-0 left-0 z-40 w-64 shrink-0 bg-gradient-to-b from-teal-800 to-teal-950 text-white flex flex-col shadow-2xl transition-all duration-300 ease-in-out -translate-x-full md:translate-x-0">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-5 py-5 border-b border-teal-700/50">
            <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center shadow p-1">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" class="w-full h-full object-contain" alt="Logo">
                @else
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                @endif
            </div>
            <div>
                <div class="font-bold text-sm tracking-wider leading-none">SIPESDA</div>
                <div class="text-teal-300 text-xs font-medium mt-0.5">Panel Staff Desa</div>
            </div>
        </div>

        <!-- User Info -->
        <div class="px-5 py-4 border-b border-teal-700/50">
            <a href="{{ route('profil') }}" class="flex items-center gap-3 group hover:bg-white/10 p-2 -m-2 rounded-xl transition" title="Lihat Profil Saya">
                <div class="w-10 h-10 rounded-full bg-teal-600 border-2 border-teal-400 flex items-center justify-center font-black text-base group-hover:scale-105 transition-transform">
                    {{ substr(Auth::user()->nama, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-bold truncate group-hover:text-teal-200 transition">{{ Auth::user()->nama }}</div>
                    <div class="text-teal-300 text-xs flex items-center gap-1">
                        {{ Auth::user()->staffDesa->jabatan ?? 'Staff Desa' }}
                        <svg class="w-3 h-3 text-teal-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Nav Menu -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <p class="text-teal-400 text-xs font-bold uppercase tracking-widest px-3 mb-2">Utama</p>

            <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition-all text-sm font-medium">
                <svg class="w-5 h-5 shrink-0 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="{{ route('staff.akun.index') }}" class="sidebar-item {{ request()->routeIs('staff.akun.*') ? 'active' : '' }} relative flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition-all text-sm font-medium">
                <svg class="w-5 h-5 shrink-0 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Verifikasi Akun
                @php $pendingCount = \App\Models\Penduduk::where('status_akun','pending')->where('role','warga')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center w-5 h-5 bg-red-500 text-white text-xs font-black rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>

            <p class="text-teal-400 text-xs font-bold uppercase tracking-widest px-3 mt-4 mb-2">Permohonan</p>

            <a href="{{ route('staff.permohonan.index') }}" class="sidebar-item {{ request()->routeIs('staff.permohonan.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition-all text-sm font-medium">
                <svg class="w-5 h-5 shrink-0 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Daftar Permohonan
                @php $antrian = \App\Models\PermohonanSurat::whereIn('status',['menunggu_verifikasi','revisi'])->count(); @endphp
                @if($antrian > 0)
                    <span class="ml-auto inline-flex items-center justify-center w-5 h-5 bg-yellow-400 text-yellow-900 text-xs font-black rounded-full">{{ $antrian }}</span>
                @endif
            </a>

            <p class="text-teal-400 text-xs font-bold uppercase tracking-widest px-3 mt-4 mb-2">Master Data</p>

            <a href="{{ route('staff.jenis_surat.index') }}" class="sidebar-item {{ request()->routeIs('staff.jenis_surat.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition-all text-sm font-medium">
                <svg class="w-5 h-5 shrink-0 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Jenis Surat
            </a>

            <a href="{{ route('staff.penduduk.index') }}" class="sidebar-item {{ request()->routeIs('staff.penduduk.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition-all text-sm font-medium">
                <svg class="w-5 h-5 shrink-0 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Data Penduduk
            </a>
        </nav>

        <!-- Tombol Tutup Sidebar -->
        <div class="p-4 border-t border-teal-700/50">
            <button type="button" onclick="toggleSidebar()" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-white/5 hover:bg-white/15 text-teal-200 hover:text-white transition-all text-sm font-medium cursor-pointer group" title="Sembunyikan / Tutup Sidebar (Ctrl+B)">
                <span class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 shrink-0 text-teal-300 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                    <span>Tutup Sidebar</span>
                </span>
                <span class="text-[10px] px-1.5 py-0.5 rounded bg-teal-900/80 text-teal-300 border border-teal-700/60 font-mono">Ctrl+B</span>
            </button>

            <!-- Hidden Logout Form (Digunakan oleh Dropdown Profil di Header) -->
            <form method="POST" action="{{ route('logout') }}" id="staff-logout-form" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <!-- ======== MAIN CONTENT ======== -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
        <!-- Top Bar -->
        <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-3.5 flex items-center justify-between shadow-sm shrink-0">
            <div class="flex items-center gap-3">
                <!-- Toggle Sidebar Button -->
                <button type="button" onclick="toggleSidebar()" class="p-2 -ml-1 sm:-ml-2 rounded-xl text-gray-500 hover:text-teal-700 hover:bg-slate-100 transition focus:outline-none cursor-pointer" title="Buka / Tutup Sidebar (Ctrl+B)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div>
                    <h2 class="font-bold text-gray-800 text-base sm:text-lg leading-none">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-gray-500 text-xs mt-0.5">@yield('page-subtitle', 'Panel Administrasi Staff Desa Medini')</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>

                <!-- Profile Dropdown in Staff Header -->
                <div class="relative shrink-0" id="profile-dropdown-wrapper">
                    <button type="button" onclick="toggleProfileDropdown(event)" class="flex items-center gap-2 p-1 sm:pr-3 rounded-full hover:bg-slate-100 border border-transparent hover:border-slate-200 transition focus:outline-none cursor-pointer" title="Menu Profil">
                        <div class="w-8 h-8 rounded-full bg-teal-700 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                            {{ substr(Auth::user()->nama, 0, 1) }}
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 hidden md:inline">{{ Auth::user()->nama }}</span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" id="profile-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="profile-dropdown-menu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50 animate-fade-in origin-top-right">
                        <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">
                            <p class="text-[11px] text-gray-400">Masuk sebagai</p>
                            <p class="text-sm font-bold text-gray-900 truncate mt-0.5">{{ Auth::user()->nama }}</p>
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-teal-100 text-teal-800 mt-1">
                                {{ Auth::user()->staffDesa->jabatan ?? 'Staff Desa' }}
                            </span>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs sm:text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-800 font-medium group transition">
                                <div class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-teal-100 text-gray-500 group-hover:text-teal-700 flex items-center justify-center transition shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold leading-tight">Lihat Profil</p>
                                    <p class="text-[11px] text-gray-400 font-normal">Informasi data diri Anda</p>
                                </div>
                            </a>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs sm:text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-800 font-medium group transition">
                                <div class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-teal-100 text-gray-500 group-hover:text-teal-700 flex items-center justify-center transition shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold leading-tight">Dashboard</p>
                                    <p class="text-[11px] text-gray-400 font-normal">Halaman administrasi staff</p>
                                </div>
                            </a>
                        </div>
                        <div class="border-t border-slate-100 my-1"></div>
                        <div class="px-2 py-1">
                            <button type="button" onclick="confirmLogout(event, document.getElementById('staff-logout-form'))" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs sm:text-sm text-red-600 hover:bg-red-50 font-semibold cursor-pointer transition">
                                <div class="w-7 h-7 rounded-lg bg-red-50 text-red-500 flex items-center justify-center transition shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold leading-tight">Logout</p>
                                    <p class="text-[11px] text-red-400 font-normal">Keluar dari sistem</p>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Scrollable Page Content -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-emerald-800 font-medium text-sm">{!! session('success') !!}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-red-800 font-medium text-sm">{{ session('error') }}</p>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 shadow-sm">
                    <p class="text-red-800 font-bold text-sm mb-2">Terdapat kesalahan:</p>
                    <ul class="text-red-700 text-sm space-y-1 list-disc list-inside">
                        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@include('components.pdf_preview_modal')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('main-sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        if (!sidebar) return;

        const isMobile = window.innerWidth < 768;

        if (isMobile) {
            const isClosed = sidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                if (backdrop) backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                if (backdrop) backdrop.classList.add('hidden');
            }
        } else {
            const isCollapsed = sidebar.classList.contains('md:-ml-64');
            if (isCollapsed) {
                sidebar.classList.remove('md:-ml-64');
                localStorage.setItem('staff_sidebar_collapsed', 'false');
            } else {
                sidebar.classList.add('md:-ml-64');
                localStorage.setItem('staff_sidebar_collapsed', 'true');
            }
        }
    }

    // Keyboard shortcut Ctrl+B untuk buka/tutup sidebar
    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'b') {
            e.preventDefault();
            toggleSidebar();
        }
    });

    // Inisialisasi status collapse di desktop dari localStorage
    document.addEventListener('DOMContentLoaded', function () {
        if (window.innerWidth >= 768) {
            if (localStorage.getItem('staff_sidebar_collapsed') === 'true') {
                const sidebar = document.getElementById('main-sidebar');
                if (sidebar) sidebar.classList.add('md:-ml-64');
            }
        }
    });

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
        const targetForm = form || (event ? event.target.closest('form') : document.getElementById('staff-logout-form'));
        
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

    /**
     * Konfirmasi Hapus Data dengan SweetAlert2
     */
    function confirmDelete(event, form, title = 'Konfirmasi Hapus Data', text = 'Data yang dihapus tidak dapat dikembalikan. Apakah Anda yakin?') {
        if (event) event.preventDefault();
        const targetForm = form || (event ? event.target.closest('form') : null);
        if (!targetForm) return;

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'rounded-2xl shadow-xl',
                confirmButton: 'rounded-xl font-bold px-5 py-2.5 text-sm',
                cancelButton: 'rounded-xl font-medium px-5 py-2.5 text-sm'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                targetForm.submit();
            }
        });
    }

    /**
     * Konfirmasi Aksi Umum dengan SweetAlert2
     */
    function confirmAction(event, form, title = 'Konfirmasi Tindakan', text = 'Apakah Anda yakin ingin melanjutkan?', icon = 'question', confirmColor = '#0d9488', confirmText = 'Ya, Lanjutkan') {
        if (event) event.preventDefault();
        const targetForm = form || (event ? event.target.closest('form') : null);
        if (!targetForm) return;

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#6b7280',
            confirmButtonText: confirmText,
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'rounded-2xl shadow-xl',
                confirmButton: 'rounded-xl font-bold px-5 py-2.5 text-sm',
                cancelButton: 'rounded-xl font-medium px-5 py-2.5 text-sm'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                targetForm.submit();
            }
        });
    }

    // ==========================================
    // SISTEM TOAST NOTIFIKASI (SWEETALERT2)
    // ==========================================
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        customClass: {
            popup: 'rounded-2xl shadow-2xl border border-gray-100 text-sm font-medium',
            title: 'text-sm font-semibold text-gray-800'
        }
    });

    window.Toast = Toast;
    window.showToast = function(message, icon = 'success', title = '') {
        Toast.fire({
            icon: icon,
            html: title ? `<strong class="block mb-1">${title}</strong>${message}` : message
        });
    };
    window.toast = {
        success: (msg, title = '') => window.showToast(msg, 'success', title),
        error:   (msg, title = '') => window.showToast(msg, 'error', title),
        warning: (msg, title = '') => window.showToast(msg, 'warning', title),
        info:    (msg, title = '') => window.showToast(msg, 'info', title)
    };

    // Tangkap juga submit event langsung jika ada form logout atau form delete lain
    document.addEventListener('DOMContentLoaded', function () {
        // Otomatis picu Toast dari flash session Laravel
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                html: {!! json_encode(session('success')) !!}
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                html: {!! json_encode(session('error')) !!}
            });
        @endif

        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                html: {!! json_encode(session('warning')) !!}
            });
        @endif

        @if(session('info'))
            Toast.fire({
                icon: 'info',
                html: {!! json_encode(session('info')) !!}
            });
        @endif

        @if($errors->any())
            Toast.fire({
                icon: 'error',
                html: {!! json_encode($errors->first()) !!}
            });
        @endif

        const logoutForms = document.querySelectorAll('form[action="{{ route('logout') }}"]');
        logoutForms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                if (form.dataset.confirmed !== 'true') {
                    e.preventDefault();
                    confirmLogout(e, form);
                }
            });
        });

        // Intercept otomatis form DELETE
        document.querySelectorAll('form').forEach(function (form) {
            const hasDeleteMethod = form.querySelector('input[name="_method"][value="DELETE"]') !== null;
            if (hasDeleteMethod && !form.dataset.hasDeleteInterceptor) {
                form.dataset.hasDeleteInterceptor = 'true';
                form.addEventListener('submit', function (e) {
                    if (form.dataset.swalPassed === 'true') return;
                    e.preventDefault();

                    const title = form.getAttribute('data-confirm-title') || 'Konfirmasi Hapus Data';
                    const text = form.getAttribute('data-confirm-message') || 'Data ini akan dihapus dari sistem. Apakah Anda yakin?';

                    confirmDelete(e, form, title, text);
                });
            }
        });
    });
</script>
@stack('scripts')
</body>
</html>
