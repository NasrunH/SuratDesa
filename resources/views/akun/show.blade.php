@extends('layouts.staff')

@section('title', 'Periksa Akun - ' . $warga->nama)
@section('page-title', 'Detail Pendaftar')
@section('page-subtitle', 'Verifikasi identitas: ' . $warga->nama)

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('staff.akun.index') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:text-orange-600 hover:border-orange-300 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Periksa Akun Pendaftar</h1>
            <p class="text-gray-500 text-sm">Verifikasi data identitas dan KTP warga sebelum mengaktifkan akun</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="glass border-l-4 border-red-500 p-5 rounded-2xl flex gap-3 items-start shadow-sm">
            <svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <ul class="text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <!-- Kolom Kiri: Data Warga -->
        <div class="lg:col-span-3 space-y-6">
            <div class="glass rounded-3xl p-6 border border-white/50 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2 border-b border-gray-100 pb-4">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Data Pendaftar
                </h2>
                <dl class="space-y-4 text-sm">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50/60 rounded-xl p-4 border border-gray-100">
                            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">NIK</dt>
                            <dd class="font-mono font-bold text-gray-900 text-base tracking-wider">{{ $warga->nik }}</dd>
                        </div>
                        <div class="bg-gray-50/60 rounded-xl p-4 border border-gray-100">
                            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Nama Lengkap</dt>
                            <dd class="font-bold text-gray-900 text-base">{{ $warga->nama }}</dd>
                        </div>
                    </div>
                    <div class="bg-gray-50/60 rounded-xl p-4 border border-gray-100">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Alamat</dt>
                        <dd class="text-gray-900">{{ $warga->alamat }}</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50/60 rounded-xl p-4 border border-gray-100">
                            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">No. HP / WhatsApp</dt>
                            <dd class="font-medium text-gray-900">{{ $warga->no_hp ?? '-' }}</dd>
                        </div>
                        <div class="bg-gray-50/60 rounded-xl p-4 border border-gray-100">
                            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Email</dt>
                            <dd class="font-medium text-gray-900 text-xs">{{ $warga->email ?? '-' }}</dd>
                        </div>
                    </div>
                    <div class="bg-gray-50/60 rounded-xl p-4 border border-gray-100">
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Waktu Pendaftaran</dt>
                        <dd class="font-medium text-gray-900">{{ $warga->created_at->translatedFormat('l, d F Y \p\u\k\u\l H:i') }} ({{ $warga->created_at->diffForHumans() }})</dd>
                    </div>
                </dl>
            </div>

            <!-- KTP Photo -->
            <div class="glass rounded-3xl p-6 border border-white/50 shadow-sm">
                <h2 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2 border-b border-gray-100 pb-4">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    Foto KTP yang Diunggah
                </h2>
                @if($warga->foto_ktp)
                    <div class="rounded-2xl overflow-hidden border-2 border-gray-200 bg-gray-50 shadow-inner">
                        <img src="{{ asset('storage/' . $warga->foto_ktp) }}" alt="Foto KTP {{ $warga->nama }}" class="w-full object-contain max-h-64">
                    </div>
                    <a href="{{ asset('storage/' . $warga->foto_ktp) }}" target="_blank" class="mt-3 inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Buka di tab baru (Full Size)
                    </a>
                @else
                    <div class="rounded-2xl bg-red-50 border-2 border-dashed border-red-200 p-8 text-center">
                        <svg class="w-10 h-10 text-red-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-red-600 font-semibold text-sm">Warga tidak mengunggah foto KTP.</p>
                        <p class="text-red-400 text-xs mt-1">Ini bisa menjadi alasan untuk menolak akun ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: Aksi -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Aktivasi -->
            <div class="glass rounded-3xl p-6 border border-emerald-100 bg-emerald-50/30 shadow-sm">
                <h3 class="font-bold text-emerald-800 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Aktifkan Akun
                </h3>
                <p class="text-sm text-emerald-700 mb-5 font-light">Jika data KTP warga <strong>terbukti valid</strong> dan sesuai dengan catatan kependudukan desa, klik tombol di bawah untuk mengaktifkan akun.</p>
                <form action="{{ route('staff.akun.aktivasi', $warga->id_penduduk) }}" method="POST" onsubmit="return confirm('Yakin ingin MENGAKTIFKAN akun {{ $warga->nama }}?')">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 bg-gradient-to-r from-emerald-600 to-green-500 text-white font-bold rounded-xl shadow-md shadow-emerald-200 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-300 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Ya, Aktifkan Akun Ini
                    </button>
                </form>
            </div>

            <!-- Tolak -->
            <div class="glass rounded-3xl p-6 border border-red-100 bg-red-50/20 shadow-sm">
                <h3 class="font-bold text-red-800 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    Tolak / Non-aktifkan Akun
                </h3>
                <p class="text-sm text-red-700 mb-4 font-light">Jika data <strong>tidak valid</strong>, tidak terdaftar sebagai warga Desa Medini, atau KTP palsu/tidak jelas, tolak pendaftaran ini.</p>
                <form action="{{ route('staff.akun.tolak', $warga->id_penduduk) }}" method="POST" onsubmit="return confirm('Yakin ingin MENOLAK akun {{ $warga->nama }}? Alasan penolakan wajib diisi.')">
                    @csrf
                    <div class="mb-4">
                        <label for="catatan_penolakan" class="block text-sm font-semibold text-red-800 mb-1.5">Alasan Penolakan <span class="text-red-500">*</span></label>
                        <textarea id="catatan_penolakan" name="catatan_penolakan" rows="3" required minlength="10" class="appearance-none block w-full px-4 py-3 border border-red-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-red-400/50 focus:border-red-400 transition text-sm" placeholder="Contoh: Data NIK tidak ditemukan di buku induk desa / foto KTP tidak terbaca jelas..."></textarea>
                    </div>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 bg-white border-2 border-red-400 text-red-700 font-bold rounded-xl hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Tolak Pendaftaran Ini
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
