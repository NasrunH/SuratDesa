@extends($layout)

@section('title', 'Profil Saya')
@section('page-title', 'Profil Pengguna')
@section('page-subtitle', 'Informasi akun dan data kependudukan terdaftar')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Top Bar Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-200 hover:border-green-300 hover:bg-green-50 text-gray-700 hover:text-green-700 rounded-xl transition text-xs sm:text-sm font-semibold shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>

        <div class="text-xs text-gray-500 hidden sm:block">
            Terdaftar sejak: <span class="font-semibold text-gray-700">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
        </div>
    </div>

    <!-- Main Profile Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Identity & Status Card -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-gray-150 shadow-sm p-6 flex flex-col items-center text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-br from-green-500/20 via-emerald-500/15 to-transparent -z-0"></div>

                <!-- Avatar -->
                <div class="w-24 h-24 rounded-3xl bg-gradient-to-tr from-green-600 to-emerald-400 border-4 border-white flex items-center justify-center font-black text-white text-3xl shadow-lg mb-3 relative z-10">
                    {{ substr($user->nama, 0, 1) }}
                </div>

                <div class="relative z-10 w-full">
                    <h2 class="text-xl font-bold text-gray-900 leading-snug">{{ $user->nama }}</h2>
                    <p class="text-xs text-gray-500 font-mono mt-1">NIK: {{ $user->nik }}</p>

                    @php 
                        $roleLabels = [
                            'warga' => 'Warga / Pemohon',
                            'staff' => 'Staf Administrasi Desa',
                            'kades' => 'Kepala Desa Medini'
                        ];
                        $roleColors = [
                            'warga' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 
                            'staff' => 'bg-blue-50 text-blue-700 border-blue-200', 
                            'kades' => 'bg-amber-50 text-amber-700 border-amber-200'
                        ];
                    @endphp
                    <div class="mt-2.5">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $roleLabels[$user->role] ?? ucfirst($user->role) }}
                        </span>
                    </div>

                    <div class="w-full border-t border-gray-100 my-5"></div>

                    <!-- Meta Details List -->
                    <div class="space-y-3.5 text-left text-xs sm:text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Status Akun:</span>
                            @if($user->status_akun === 'aktif')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif Terverifikasi
                                </span>
                            @elseif($user->status_akun === 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Menunggu Verifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Nonaktif
                                </span>
                            @endif
                        </div>

                        @if($user->role === 'staff' && $user->staffDesa)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500">Jabatan:</span>
                                <span class="font-semibold text-gray-800">{{ $user->staffDesa->jabatan ?? '-' }}</span>
                            </div>
                            @if($user->staffDesa->nip)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500">NIP:</span>
                                    <span class="font-mono text-gray-800 font-semibold">{{ $user->staffDesa->nip }}</span>
                                </div>
                            @endif
                        @endif

                        @if($user->role === 'kades' && $user->kepalaDesa)
                            @if($user->kepalaDesa->nip)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500">NIP Kades:</span>
                                    <span class="font-mono text-gray-800 font-semibold">{{ $user->kepalaDesa->nip }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500">Periode Jabatan:</span>
                                <span class="font-semibold text-gray-800">
                                    {{ $user->kepalaDesa->periode_mulai ?? '-' }} s/d {{ $user->kepalaDesa->periode_selesai ?? 'Sekarang' }}
                                </span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Total Pengajuan:</span>
                            <span class="font-bold text-gray-900">{{ $totalPengajuan }} Surat</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Card -->
            <div class="bg-white rounded-3xl border border-gray-150 shadow-sm p-5 space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">Keamanan & Sesi</h3>
                <button type="button" onclick="confirmLogout(event, document.getElementById('profile-logout-form'))" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl text-xs sm:text-sm font-bold transition shadow-sm cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout dari Akun
                </button>
                <form id="profile-logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Right Column: Detailed Citizen & Account Information -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-gray-150 shadow-sm p-6 sm:p-8 space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-2.5 h-6 bg-green-500 rounded-full"></span>
                        Data Kependudukan Terdaftar
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">Data identitas resmi yang terhubung dengan akun SIPESDA Anda.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <!-- NIK -->
                    <div class="bg-gray-50/70 rounded-2xl p-4 border border-gray-150">
                        <span class="text-xs text-gray-400 block font-semibold uppercase tracking-wider">Nomor Induk Kependudukan (NIK)</span>
                        <p class="text-sm sm:text-base font-bold text-gray-900 font-mono mt-1">{{ $user->nik }}</p>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="bg-gray-50/70 rounded-2xl p-4 border border-gray-150">
                        <span class="text-xs text-gray-400 block font-semibold uppercase tracking-wider">Nama Lengkap (KTP)</span>
                        <p class="text-sm sm:text-base font-bold text-gray-900 mt-1">{{ $user->nama }}</p>
                    </div>

                    <!-- No WhatsApp / HP -->
                    <div class="bg-gray-50/70 rounded-2xl p-4 border border-gray-150">
                        <span class="text-xs text-gray-400 block font-semibold uppercase tracking-wider">Nomor HP / WhatsApp</span>
                        <p class="text-sm sm:text-base font-semibold text-gray-900 mt-1 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $user->no_hp ?: '-' }}
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="bg-gray-50/70 rounded-2xl p-4 border border-gray-150">
                        <span class="text-xs text-gray-400 block font-semibold uppercase tracking-wider">Alamat Email</span>
                        <p class="text-sm sm:text-base font-semibold text-gray-900 mt-1 truncate">
                            {{ $user->email ?: 'Belum ditambahkan' }}
                        </p>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="sm:col-span-2 bg-gray-50/70 rounded-2xl p-4 border border-gray-150">
                        <span class="text-xs text-gray-400 block font-semibold uppercase tracking-wider">Alamat Domisili</span>
                        <p class="text-sm sm:text-base font-medium text-gray-800 mt-1 leading-relaxed">
                            {{ $user->alamat ?: 'Desa Medini, Kec. Undaan, Kab. Kudus' }}
                        </p>
                    </div>
                </div>

                <!-- Foto KTP Section -->
                <div class="border-t border-gray-100 pt-6 space-y-3">
                    <h4 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Lampiran Berkas KTP
                    </h4>

                    @if($user->foto_ktp)
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200 flex flex-col sm:flex-row items-center gap-4">
                            <div class="w-full sm:w-48 h-32 rounded-xl overflow-hidden bg-black/5 border border-gray-300 shrink-0">
                                <img src="{{ asset('storage/' . $user->foto_ktp) }}" alt="Foto KTP {{ $user->nama }}" class="w-full h-full object-cover">
                            </div>
                            <div class="space-y-2 text-center sm:text-left">
                                <p class="text-xs font-semibold text-gray-700">Foto KTP Resmi Terverifikasi</p>
                                <p class="text-xs text-gray-400">Berkas ini digunakan sebagai bukti verifikasi administrasi kependudukan.</p>
                                <a href="{{ asset('storage/' . $user->foto_ktp) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-green-600 hover:text-green-800 transition">
                                    Buka Foto KTP Ukuran Penuh
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-2xl p-5 border border-dashed border-gray-200 text-center text-xs text-gray-400">
                            Tidak ada lampiran foto KTP yang diunggah.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

