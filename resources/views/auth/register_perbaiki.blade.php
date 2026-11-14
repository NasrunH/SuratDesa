@extends('layouts.app')

@section('title', 'Perbaiki Data Pendaftaran')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-amber-50/50 to-orange-100/50 backdrop-blur-sm -z-10 rounded-3xl hidden md:block border border-white shadow-2xl scale-[0.98]"></div>
    <div class="absolute -top-20 -left-20 w-64 h-64 bg-amber-400 rounded-full blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-orange-500 rounded-full blur-3xl opacity-20 animate-pulse delay-700"></div>

    <div class="max-w-3xl w-full space-y-8 glass p-8 md:p-12 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white/60 relative z-10 animate-fade-in-up">
        <div class="text-center max-w-xl mx-auto">
            <span class="inline-block bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                Perbaikan Data Akun
            </span>
            <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">
                Perbaiki Pendaftaran SIPESDA
            </h2>
            <p class="mt-2 text-sm text-gray-600 font-medium">
                Pendaftaran akun Anda memerlukan perbaikan. Silakan periksa catatan penolakan dari petugas dan perbaiki data Anda di bawah ini.
            </p>
        </div>

        {{-- ALASAN PENOLAKAN DARI PETUGAS --}}
        @if($warga->catatan_penolakan)
            <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h4 class="text-sm font-bold text-red-800">Catatan dari Staff Desa:</h4>
                        <p class="text-sm text-red-700 mt-1 leading-relaxed">{{ $warga->catatan_penolakan }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50/80 backdrop-blur-md border border-red-200 rounded-xl p-5 shadow-sm animate-fade-in">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 shrink-0 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div class="text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('register.perbaiki.update', $warga->id_penduduk) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white/50 p-6 rounded-2xl border border-white space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nik" class="block text-sm font-semibold text-gray-700 mb-1.5">NIK KTP <span class="text-red-500">*</span></label>
                        <input id="nik" name="nik" type="text" value="{{ old('nik', $warga->nik) }}" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all sm:text-sm shadow-sm" placeholder="16 Digit NIK">
                    </div>
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
                        <input id="nama" name="nama" type="text" value="{{ old('nama', $warga->nama) }}" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all sm:text-sm shadow-sm" placeholder="Nama Lengkap">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                        <input id="email" name="email" type="email" value="{{ old('email', $warga->email) }}" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all sm:text-sm shadow-sm" placeholder="email@contoh.com">
                        <p class="text-xs text-gray-500 mt-1">Pastikan email aktif untuk menerima notifikasi status akun dan surat.</p>
                    </div>
                    <div>
                        <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-1.5">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                        <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp', $warga->no_hp) }}" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all sm:text-sm shadow-sm" placeholder="08123456789">
                    </div>
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Lengkap (RT/RW) <span class="text-red-500">*</span></label>
                    <textarea id="alamat" name="alamat" rows="2" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all sm:text-sm shadow-sm" placeholder="Contoh: Jl. Merdeka No 1, RT 01 / RW 02">{{ old('alamat', $warga->alamat) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-gray-200">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Ganti Password <span class="text-gray-400 font-normal">(Kosongkan bila tidak diubah)</span></label>
                        <input id="password" name="password" type="password" class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all sm:text-sm shadow-sm" placeholder="Password baru (opsional)">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all sm:text-sm shadow-sm" placeholder="Ketik ulang password baru">
                    </div>
                </div>

                <div>
                    <label for="foto_ktp" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Unggah Ulang Foto KTP Fisik 
                        @if(!$warga->foto_ktp) <span class="text-red-500">*</span> @else <span class="text-gray-400 font-normal">(Opsional jika tidak diganti)</span> @endif
                    </label>
                    
                    @if($warga->foto_ktp)
                        <div class="mb-3 flex items-center justify-between gap-4 p-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/' . $warga->foto_ktp) }}" alt="Foto KTP Sebelumnya" class="w-16 h-12 object-cover rounded-lg border cursor-pointer hover:opacity-80 transition" onclick="previewDocument('{{ asset('storage/' . $warga->foto_ktp) }}', 'Foto KTP Sebelumnya')" title="Klik untuk pratinjau">
                                <div class="text-xs text-gray-600">
                                    <span class="font-semibold block text-gray-800">Foto KTP saat ini sudah ada</span>
                                    Pilih file gambar di bawah jika Anda ingin menggantinya.
                                </div>
                            </div>
                            <button type="button" onclick="previewDocument('{{ asset('storage/' . $warga->foto_ktp) }}', 'Foto KTP Sebelumnya')" class="shrink-0 px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-lg transition shadow-sm cursor-pointer flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Pratinjau
                            </button>
                        </div>
                    @endif

                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl bg-white/50 hover:bg-white/80 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center mt-2">
                                <label for="foto_ktp" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500 px-2 py-0.5">
                                    <span>Pilih file gambar KTP baru</span>
                                    <input id="foto_ktp" name="foto_ktp" type="file" @if(!$warga->foto_ktp) required @endif class="sr-only" accept="image/jpeg,image/png,image/jpg" onchange="updateKtpLabel(this)">
                                </label>
                            </div>
                            <p id="ktp-filename" class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 transition text-center sm:text-left">
                    &larr; Kembali ke Halaman Login
                </a>
                <button type="submit" class="group relative flex justify-center items-center gap-2 py-3.5 px-8 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-amber-600 to-orange-500 hover:from-amber-700 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-300 shadow-lg shadow-amber-200 hover:shadow-xl hover:shadow-amber-300 hover:-translate-y-0.5 w-full sm:w-auto">
                    Simpan & Kirim Ulang Verifikasi
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateKtpLabel(input) {
        const label = document.getElementById('ktp-filename');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeMb = (file.size / 1024 / 1024).toFixed(2);
            label.textContent = 'File baru dipilih: ' + file.name + ' (' + sizeMb + ' MB)';
            label.classList.remove('text-gray-500');
            label.classList.add('text-amber-600', 'font-semibold');
        } else {
            label.textContent = 'PNG, JPG up to 2MB';
            label.classList.remove('text-amber-600', 'font-semibold');
            label.classList.add('text-gray-500');
        }
    }
</script>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
@endsection
