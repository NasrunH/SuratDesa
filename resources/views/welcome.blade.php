<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPESDA - Sistem Informasi Pelayanan Surat Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Outfit', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
        }
        .hero-gradient {
            background: radial-gradient(circle at 80% 20%, rgba(20, 184, 166, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 10% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
        }
    </style>
</head>
<body class="bg-slate-50 text-gray-800 antialiased min-h-screen flex flex-col hero-gradient">

    <!-- ======== NAVBAR ======== -->
    <header class="sticky top-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-600 to-emerald-500 flex items-center justify-center shadow-md shadow-teal-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <span class="font-bold text-lg text-teal-900 tracking-wider block leading-none">SIPESDA</span>
                    <span class="text-[10px] text-teal-600 font-semibold tracking-wide uppercase">Layanan Surat Desa</span>
                </div>
            </a>
            
            <nav class="flex items-center gap-3 sm:gap-4">
                <a href="#layanan-surat" class="px-4 py-2 text-slate-700 hover:text-teal-700 text-sm font-semibold transition hidden sm:inline-block">
                    Katalog Surat
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-sm font-semibold transition-all shadow-md shadow-teal-600/10 hover:-translate-y-0.5">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-slate-700 hover:text-teal-700 text-sm font-semibold transition">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-sm font-semibold transition-all shadow-md shadow-teal-600/10 hover:-translate-y-0.5">
                            Daftar Warga
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <!-- ======== HERO SECTION ======== -->
    <main class="flex-1 flex flex-col justify-center items-center px-6 py-12 md:py-20 max-w-7xl mx-auto w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center w-full">
            <!-- Left Info -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left animate-fade-in-up">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-teal-50 border border-teal-200 text-teal-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span> Pelayanan Mandiri & Online
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 leading-tight">
                    Ajukan Surat Desa <br class="hidden sm:inline">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-teal-600 to-emerald-500">Cukup dari Rumah</span>
                </h1>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 font-light leading-relaxed">
                    Ajukan permohonan surat kependudukan, surat usaha, dan administrasi desa lainnya secara digital. Praktis, transparan, dan terverifikasi tanda tangan digital resmi.
                </p>
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="#layanan-surat" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-teal-600/20 hover:-translate-y-0.5">
                        Lihat Pilihan Surat
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 rounded-xl transition-all font-bold shadow-sm hover:bg-slate-50">
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 rounded-xl transition-all font-bold shadow-sm hover:bg-slate-50">
                            Daftar Akun Baru
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Right Vector / Graphic -->
            <div class="lg:col-span-5 relative flex justify-center lg:justify-end animate-fade-in-up" style="animation-delay: 200ms;">
                <div class="absolute inset-0 bg-gradient-to-tr from-teal-400 to-emerald-400 rounded-full blur-3xl opacity-20 scale-75"></div>
                <!-- Premium card mockup -->
                <div class="relative w-full max-w-[400px] bg-white/80 backdrop-blur-md border border-white/60 p-8 rounded-3xl shadow-xl flex flex-col gap-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-400"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                            <span class="w-3 h-3 rounded-full bg-green-400"></span>
                        </div>
                        <span class="text-xs text-slate-400 font-mono">Verifikasi Instan</span>
                    </div>

                    <!-- Progress bar items -->
                    <div class="space-y-4">
                        <div class="p-4 bg-teal-50/50 border border-teal-100/50 rounded-2xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-teal-500/10 text-teal-600 flex items-center justify-center font-bold text-sm">1</div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Warga Mengisi Form</h4>
                                <p class="text-xs text-slate-500">Lengkapi data syarat permohonan</p>
                            </div>
                        </div>
                        <div class="p-4 bg-emerald-50/50 border border-emerald-100/50 rounded-2xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold text-sm">2</div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Verifikasi oleh Staff</h4>
                                <p class="text-xs text-slate-500">Pengecekan syarat berkas berkala</p>
                            </div>
                        </div>
                        <div class="p-4 bg-indigo-50/50 border border-indigo-100/50 rounded-2xl flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-600 flex items-center justify-center font-bold text-sm">3</div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Persetujuan Kades</h4>
                                <p class="text-xs text-slate-500">Surat terbit & QR Code TTD digital</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======== KATALOG LAYANAN SURAT ======== -->
        <section id="layanan-surat" class="w-full mt-20 pt-16 border-t border-slate-200/60 scroll-mt-20">
            <div class="text-center max-w-3xl mx-auto mb-10 space-y-3">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-teal-50 border border-teal-200 text-teal-700 uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Katalog Layanan Surat Desa
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Pilihan Jenis Surat Online
                </h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    Pilih jenis surat administrasi desa yang Anda butuhkan. Klik surat untuk langsung mengisi formulir permohonan atau masuk ke akun warga Anda.
                </p>

                <!-- Search Input -->
                <div class="max-w-md mx-auto pt-4">
                    <div class="relative">
                        <input type="text" id="searchSurat" placeholder="Cari nama surat (contoh: SKU, SKTM, Domisili)..." 
                               class="w-full pl-11 pr-4 py-3 bg-white/90 backdrop-blur-md border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 shadow-sm transition placeholder-slate-400">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            @if($jenisSurat->isEmpty())
                <div class="bg-white/80 backdrop-blur-md rounded-3xl border border-dashed border-slate-300 p-12 text-center max-w-lg mx-auto shadow-sm">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-700 text-base">Belum Ada Layanan Surat Aktif</h4>
                    <p class="text-xs text-slate-500 mt-1">Saat ini belum ada formulir surat yang dipublikasikan oleh petugas desa.</p>
                </div>
            @else
                <div id="gridSurat" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 w-full">
                    @foreach($jenisSurat as $surat)
                        @php
                            $targetUrl = auth()->check()
                                ? (auth()->user()->role === 'warga' ? route('warga.permohonan.form', $surat->id_jenis_surat) : route('dashboard'))
                                : route('warga.permohonan.form', $surat->id_jenis_surat);
                        @endphp
                        <div class="surat-card group bg-white/90 backdrop-blur-md rounded-3xl border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col overflow-hidden"
                             data-title="{{ $surat->nama_surat }} {{ $surat->deskripsi }}">
                            <!-- Thumbnail Image Header -->
                            <a href="{{ $targetUrl }}" class="relative h-48 w-full overflow-hidden bg-slate-100 block shrink-0">
                                <img src="{{ $surat->thumbnail_url }}" 
                                     alt="{{ $surat->nama_surat }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-900/10 to-transparent opacity-60 group-hover:opacity-40 transition-opacity"></div>
                                
                                <!-- Syarat Count Badge -->
                                <div class="absolute top-3.5 right-3.5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/95 backdrop-blur-md text-teal-800 shadow-sm border border-white/60">
                                        <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $surat->syarat_count }} Dokumen Syarat
                                    </span>
                                </div>

                                <div class="absolute bottom-3 left-3 right-3 text-white">
                                    <span class="inline-block text-[11px] font-bold tracking-wider uppercase px-2 py-0.5 rounded bg-black/40 backdrop-blur-sm text-teal-300">
                                        Pelayanan Digital
                                    </span>
                                </div>
                            </a>

                            <!-- Card Content -->
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <a href="{{ $targetUrl }}" class="block">
                                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-teal-700 transition line-clamp-1 mb-2">
                                            {{ $surat->nama_surat }}
                                        </h3>
                                    </a>
                                    <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed mb-4">
                                        {{ $surat->deskripsi ?: 'Layanan pengajuan dokumen resmi desa dengan proses cepat, verifikasi online, dan tanda tangan digital QR Code.' }}
                                    </p>
                                </div>

                                <!-- Bottom Action -->
                                <div class="pt-4 border-t border-slate-100 mt-2 space-y-2">
                                    @auth
                                        @if(auth()->user()->role === 'warga')
                                            <a href="{{ route('warga.permohonan.form', $surat->id_jenis_surat) }}" 
                                               class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 transition shadow-md shadow-teal-600/10 hover:shadow-teal-600/25">
                                                <span>Buat Surat Ini</span>
                                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        @else
                                            <a href="{{ route('dashboard') }}" 
                                               class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                                                <span>Buka Panel {{ ucfirst(auth()->user()->role) }}</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('warga.permohonan.form', $surat->id_jenis_surat) }}" 
                                           class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 transition shadow-md shadow-teal-600/10 hover:shadow-teal-600/25">
                                            <span>Ajukan Surat Ini</span>
                                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                        <div class="flex items-center justify-between text-xs text-slate-400 px-1 pt-1">
                                            <span class="inline-flex items-center gap-1 text-slate-500">
                                                <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"/></svg>
                                                Perlu Login Warga
                                            </span>
                                            <a href="{{ route('register') }}" class="font-semibold text-teal-600 hover:text-teal-700 hover:underline">
                                                Belum punya? Daftar
                                            </a>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="noSuratFound" class="hidden bg-white/80 backdrop-blur-md rounded-3xl border border-slate-200 p-10 text-center max-w-md mx-auto mt-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-600">Surat yang Anda cari tidak ditemukan.</p>
                    <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
            @endif
        </section>

        <!-- ======== FEATURES SECTION ======== -->
        <section class="w-full mt-24 pt-12 border-t border-slate-200/50">
            <h2 class="text-center text-xs font-bold text-teal-600 uppercase tracking-widest mb-12">Keunggulan Pelayanan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-150 shadow-sm hover:shadow-md transition duration-300 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900">Proses Cepat & Efisien</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Hindari antrean panjang. Isi formulir dari mana saja, dan biarkan sistem memproses berkas Anda secara real-time.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-150 shadow-sm hover:shadow-md transition duration-300 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900">Validitas Terjamin</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Setiap surat dilengkapi dengan Tanda Tangan Digital berupa QR Code unik untuk memastikan keaslian dokumen.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-150 shadow-sm hover:shadow-md transition duration-300 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900">Transparansi Status</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Warga dapat melacak status verifikasi berkas secara berkala langsung dari dashboard panel pribadi masing-masing.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- ======== FOOTER ======== -->
    <footer class="bg-slate-900 text-slate-400 py-10 mt-auto shrink-0">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left">
                <span class="font-bold text-white tracking-wider block">SIPESDA</span>
                <span class="text-xs text-slate-500">© 2026 Pemerintah Desa Medini. Hak Cipta Dilindungi.</span>
            </div>
            <div class="flex items-center gap-6 text-sm">
                <span class="text-slate-500">Layanan Kontak Desa: info@medini.desa.id</span>
            </div>
        </div>
    </footer>

    <style>
        .animate-fade-in-up { animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    <script>
        document.getElementById('searchSurat')?.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.surat-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const title = card.getAttribute('data-title') || '';
                const match = title.toLowerCase().includes(query);
                card.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            const noFound = document.getElementById('noSuratFound');
            if (noFound) {
                noFound.classList.toggle('hidden', visibleCount > 0);
            }
        });
    </script>
</body>
</html>
