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

<div class="flex h-screen overflow-hidden">

    <!-- ======== SIDEBAR ======== -->
    <aside class="w-64 flex-shrink-0 bg-gradient-to-b from-teal-800 to-teal-950 text-white flex flex-col shadow-2xl">
        <!-- Logo -->
        <div class="flex items-center gap-3 px-5 py-5 border-b border-teal-700/50">
            <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center shadow">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <div class="font-bold text-sm tracking-wider leading-none">SIPESDA</div>
                <div class="text-teal-300 text-xs font-medium mt-0.5">Panel Staff Desa</div>
            </div>
        </div>

        <!-- User Info -->
        <div class="px-5 py-4 border-b border-teal-700/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-teal-600 border-2 border-teal-400 flex items-center justify-center font-black text-base">
                    {{ substr(Auth::user()->nama, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-bold truncate">{{ Auth::user()->nama }}</div>
                    <div class="text-teal-300 text-xs">{{ Auth::user()->staffDesa->jabatan ?? 'Staff Desa' }}</div>
                </div>
            </div>
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

        <!-- Logout -->
        <div class="p-4 border-t border-teal-700/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-500/20 text-teal-300 hover:text-red-300 transition-all text-sm font-medium">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar dari Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- ======== MAIN CONTENT ======== -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between shadow-sm shrink-0">
            <div>
                <h2 class="font-bold text-gray-800 text-lg leading-none">@yield('page-title', 'Dashboard')</h2>
                <p class="text-gray-500 text-xs mt-0.5">@yield('page-subtitle', 'Panel Administrasi Staff Desa Medini')</p>
            </div>
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
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

</body>
</html>
