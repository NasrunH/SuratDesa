@extends('layouts.app')

@section('title', 'Pendaftaran Warga')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-emerald-100/50 backdrop-blur-sm -z-10 rounded-3xl hidden md:block border border-white shadow-2xl scale-[0.98]"></div>
    <div class="absolute -top-20 -left-20 w-64 h-64 bg-emerald-400 rounded-full blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-green-500 rounded-full blur-3xl opacity-20 animate-pulse delay-700"></div>

    <div class="max-w-3xl w-full space-y-8 glass p-8 md:p-12 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white/60 relative z-10 animate-fade-in-up">
        <div class="text-center max-w-xl mx-auto">
            <h2 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-green-800 to-emerald-600 tracking-tight">
                Pendaftaran Akun SIPESDA
            </h2>
            <p class="mt-3 text-sm text-gray-500 font-medium">
                Lengkapi identitas diri Anda untuk mulai menggunakan layanan administrasi surat desa digital.
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-50/80 backdrop-blur-md border border-red-200 rounded-xl p-5 mb-6 shadow-sm animate-fade-in">
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

            <div class="bg-white/40 p-6 rounded-2xl border border-white space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nik" class="block text-sm font-semibold text-gray-700 mb-1.5">NIK KTP <span class="text-red-500">*</span></label>
                        <input id="nik" name="nik" type="text" value="{{ old('nik') }}" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all sm:text-sm shadow-sm" placeholder="16 Digit NIK">
                    </div>
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
                        <input id="nama" name="nama" type="text" value="{{ old('nama') }}" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all sm:text-sm shadow-sm" placeholder="Nama Lengkap">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Buat Password <span class="text-red-500">*</span></label>
                        <input id="password" name="password" type="password" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all sm:text-sm shadow-sm" placeholder="Minimal 6 karakter">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Ulangi Password <span class="text-red-500">*</span></label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all sm:text-sm shadow-sm" placeholder="Ketik ulang password">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all sm:text-sm shadow-sm" placeholder="email@contoh.com">
                    </div>
                    <div>
                        <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-1.5">No. HP / WhatsApp <span class="text-red-500">*</span></label>
                        <input id="no_hp" name="no_hp" type="text" value="{{ old('no_hp') }}" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all sm:text-sm shadow-sm" placeholder="08123456789">
                    </div>
                </div>
                
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Lengkap (RT/RW) <span class="text-red-500">*</span></label>
                    <textarea id="alamat" name="alamat" rows="2" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/80 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all sm:text-sm shadow-sm" placeholder="Contoh: Jl. Merdeka No 1, RT 01 / RW 02">{{ old('alamat') }}</textarea>
                </div>
                
                <div>
                    <label for="foto_ktp" class="block text-sm font-semibold text-gray-700 mb-1.5">Foto KTP Fisik <span class="text-gray-400 font-normal">(Opsional, disarankan)</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl bg-white/50 hover:bg-white/80 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center mt-2">
                                <label for="foto_ktp" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500 px-2 py-0.5">
                                    <span>Pilih file gambar</span>
                                    <input id="foto_ktp" name="foto_ktp" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-8 pt-6 border-t border-gray-100">
                <div class="text-sm text-center sm:text-left">
                    <span class="text-gray-600">Sudah punya akun?</span>
                    <a href="{{ route('login') }}" class="font-bold text-green-600 hover:text-green-700 transition border-b border-transparent hover:border-green-600 ml-1">Masuk di sini</a>
                </div>
                <button type="submit" class="group relative flex justify-center items-center gap-2 py-3.5 px-8 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 shadow-lg shadow-green-200 hover:shadow-xl hover:shadow-green-300 hover:-translate-y-0.5 w-full sm:w-auto">
                    Daftar Sekarang
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
@endsection
