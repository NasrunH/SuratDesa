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
            @php
                $tglDaftar = '-';
                if ($user->created_at) {
                    try {
                        $tglDaftar = \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y');
                    } catch (\Throwable $e) {
                        $tglDaftar = '-';
                    }
                }
            @endphp
            Terdaftar sejak: <span class="font-semibold text-gray-700">{{ $tglDaftar }}</span>
        </div>
    </div>

    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-4 flex items-center gap-3 shadow-sm animate-fade-in">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4 flex items-start gap-3 shadow-sm animate-fade-in">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="text-sm font-medium">
                <span class="font-bold">Terjadi kendala pada input data:</span>
                <ul class="list-disc list-inside mt-1 space-y-0.5 text-xs sm:text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

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
                                    {{ $user->kepalaDesa->periode_jabatan ?? '-' }}
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

            <!-- 1. IDENTITAS TERVERIFIKASI (READ-ONLY) -->
            <div class="bg-white rounded-3xl border border-gray-150 shadow-sm p-6 sm:p-8 space-y-6">
                <div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <span class="w-2.5 h-6 bg-emerald-500 rounded-full"></span>
                            Identitas Kependudukan Resmi
                        </h3>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-600">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Terkunci (Data Sah)
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">Data identitas ini telah diverifikasi sesuai buku induk kependudukan Desa Medini dan digunakan sebagai dasar penerbitan surat.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-1">
                    <!-- NIK -->
                    <div class="bg-gray-50/80 rounded-2xl p-4 border border-gray-200">
                        <span class="text-xs text-gray-400 block font-semibold uppercase tracking-wider">Nomor Induk Kependudukan (NIK)</span>
                        <p class="text-sm sm:text-base font-bold text-gray-900 font-mono mt-1">{{ $user->nik }}</p>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="bg-gray-50/80 rounded-2xl p-4 border border-gray-200">
                        <span class="text-xs text-gray-400 block font-semibold uppercase tracking-wider">Nama Lengkap (Sesuai KTP)</span>
                        <p class="text-sm sm:text-base font-bold text-gray-900 mt-1">{{ $user->nama }}</p>
                    </div>

                    <!-- Alamat Domisili Resmi (Terkunci) -->
                    <div class="sm:col-span-2 bg-gray-50/80 rounded-2xl p-4 border border-gray-200">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs text-gray-400 block font-semibold uppercase tracking-wider">Alamat Domisili Resmi (RT/RW)</span>
                            <span class="text-[10px] font-semibold bg-gray-200/80 text-gray-600 px-2 py-0.5 rounded-full">Sesuai KTP / KK</span>
                        </div>
                        <p class="text-sm sm:text-base font-semibold text-gray-900 leading-relaxed">{{ $user->alamat ?: 'Desa Medini, Kec. Undaan, Kab. Kudus' }}</p>
                        <p class="text-[11px] text-gray-400 mt-1 italic">*Alamat domisili dicatat permanen sesuai data administrasi kependudukan desa dan tidak dapat diubah mandiri.</p>
                    </div>
                </div>

                <!-- Foto KTP Section -->
                <div class="border-t border-gray-100 pt-5 space-y-3">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Berkas Foto KTP Terverifikasi
                    </h4>

                    @if($user->foto_ktp)
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200 flex flex-col sm:flex-row items-center gap-4">
                            <div class="w-full sm:w-44 h-28 rounded-xl overflow-hidden bg-black/5 border border-gray-300 shrink-0 cursor-pointer group relative" onclick="previewDocument('{{ asset('storage/' . $user->foto_ktp) }}', 'Foto KTP - {{ addslashes($user->nama) }}')" title="Klik untuk pratinjau">
                                <img src="{{ asset('storage/' . $user->foto_ktp) }}" alt="Foto KTP {{ $user->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                                <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 flex items-center justify-center transition text-white text-xs font-bold gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Pratinjau
                                </div>
                            </div>
                            <div class="space-y-1.5 text-center sm:text-left">
                                <p class="text-xs font-bold text-gray-800">Foto KTP Warga Resmi</p>
                                <p class="text-xs text-gray-500">Digunakan oleh Staff Desa untuk validasi berkas administrasi.</p>
                                <button type="button" onclick="previewDocument('{{ asset('storage/' . $user->foto_ktp) }}', 'Foto KTP - {{ addslashes($user->nama) }}')" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-800 transition cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Pratinjau Foto KTP
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-2xl p-4 border border-dashed border-gray-200 text-center text-xs text-gray-400">
                            Tidak ada lampiran berkas foto KTP.
                        </div>
                    @endif
                </div>
            </div>

            <!-- 2. FORM UBAH KONTAK PRIBADI -->
            <div class="bg-white rounded-3xl border border-gray-150 shadow-sm p-6 sm:p-8 space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-2.5 h-6 bg-blue-500 rounded-full"></span>
                        Ubah Kontak Pribadi
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">Perbarui alamat email dan nomor WhatsApp Anda agar notifikasi permohonan surat tersampaikan secara cepat.</p>
                </div>

                <form action="{{ route('profil.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                                Alamat Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition shadow-sm"
                                   placeholder="nama@contoh.com">
                            <p class="text-[11px] text-gray-400 mt-1">Notifikasi persetujuan surat resmi akan dikirim ke alamat ini.</p>
                        </div>

                        <!-- No HP / WhatsApp -->
                        <div>
                            <label for="no_hp" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                                No. HP / WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition shadow-sm"
                                   placeholder="Contoh: 08123456789">
                            <p class="text-[11px] text-gray-400 mt-1">Gunakan nomor aktif yang terhubung dengan WhatsApp.</p>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition shadow-md shadow-emerald-200 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan Kontak
                        </button>
                    </div>
                </form>
            </div>

            <!-- 3. FORM GANTI KATA SANDI -->
            <div class="bg-white rounded-3xl border border-gray-150 shadow-sm p-6 sm:p-8 space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-2.5 h-6 bg-amber-500 rounded-full"></span>
                        Ubah Kata Sandi (Keamanan)
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">Ganti kata sandi secara berkala dengan minimal 6 karakter untuk menjaga keamanan akun Anda.</p>
                </div>

                <form action="{{ route('profil.password') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                            Kata Sandi Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="current_password" name="current_password" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition shadow-sm"
                               placeholder="Masukkan kata sandi lama Anda">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                                Kata Sandi Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password" name="password" required minlength="6"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition shadow-sm"
                                   placeholder="Minimal 6 karakter">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-1.5">
                                Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition shadow-sm"
                                   placeholder="Ketik ulang kata sandi baru">
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl text-sm transition shadow-md shadow-amber-200 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
