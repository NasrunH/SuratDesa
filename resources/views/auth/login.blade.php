@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 to-emerald-100/50 backdrop-blur-sm -z-10 rounded-3xl hidden md:block border border-white shadow-2xl scale-[0.98]"></div>
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-400 rounded-full blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-green-500 rounded-full blur-3xl opacity-30 animate-pulse delay-700"></div>

    <div class="max-w-md w-full space-y-8 glass p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white/60 relative z-10 animate-fade-in-up">
        <div class="text-center">
            <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-emerald-400 rounded-2xl mx-auto flex items-center justify-center shadow-lg shadow-green-200 mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                Masuk ke SIPESDA
            </h2>
            <p class="mt-2 text-sm text-gray-500 font-medium">
                Silakan masukkan NIK dan Kata Sandi Anda
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-50/80 backdrop-blur-md border border-red-200 rounded-xl p-4 mb-4 text-sm text-red-600 flex items-start gap-3">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label for="nik" class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Induk Kependudukan (NIK)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        </div>
                        <input id="nik" name="nik" type="text" required value="{{ old('nik') }}" class="appearance-none block w-full pl-11 pr-3 py-3.5 border border-gray-200 rounded-xl leading-5 bg-white/60 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition duration-150 ease-in-out sm:text-sm shadow-sm" placeholder="Masukkan 16 digit NIK">
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" name="password" type="password" required class="appearance-none block w-full pl-11 pr-3 py-3.5 border border-gray-200 rounded-xl leading-5 bg-white/60 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition duration-150 ease-in-out sm:text-sm shadow-sm" placeholder="••••••••">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700 font-medium">
                        Ingat saya
                    </label>
                </div>
                <div class="text-sm">
                    <a href="#" class="font-semibold text-green-600 hover:text-green-500 transition">
                        Lupa password?
                    </a>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="group relative w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 shadow-lg shadow-green-200 hover:shadow-xl hover:shadow-green-300 hover:-translate-y-0.5">
                    Masuk Sekarang
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
            
            <div class="text-center mt-6 pt-6 border-t border-gray-100">
                <p class="text-sm text-gray-600 font-medium">
                    Belum punya akun warga? <a href="{{ route('register') }}" class="font-bold text-green-600 hover:text-green-500 transition border-b-2 border-transparent hover:border-green-500 pb-0.5">Daftar di sini</a>
                </p>
            </div>
        </form>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
