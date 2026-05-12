@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-lg w-full space-y-8 glass p-10 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white/60 text-center animate-fade-in-up">
        
        <!-- Ikon Animasi -->
        <div class="flex items-center justify-center">
            <div class="relative">
                <div class="w-24 h-24 rounded-full bg-yellow-100 border-4 border-yellow-400 flex items-center justify-center mx-auto animate-bounce-slow">
                    <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="absolute -top-1 -right-1 w-7 h-7 bg-yellow-400 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-lg">
                    !
                </div>
            </div>
        </div>

        <!-- Pesan Utama -->
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pendaftaran Terkirim!</h1>
            <p class="mt-3 text-gray-600 text-lg font-light leading-relaxed">
                @if(session('nama'))
                    Halo, <strong class="text-gray-800 font-bold">{{ session('nama') }}</strong>! 
                @endif
                Formulir pendaftaran Anda sudah kami terima.
            </p>
        </div>

        <!-- Proses Verifikasi -->
        <div class="bg-white/60 rounded-2xl p-6 border border-gray-100 text-left space-y-4">
            <h3 class="font-bold text-gray-800 text-center mb-4">Apa yang Terjadi Selanjutnya?</h3>
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold text-sm border border-yellow-200">1</div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Pemeriksaan oleh Staff Desa</p>
                    <p class="text-xs text-gray-500 mt-0.5">Staff akan memeriksa data KTP dan identitas Anda. Proses ini biasanya memakan waktu 1 × 24 jam kerja.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm border border-blue-200">2</div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Akun Diaktifkan</p>
                    <p class="text-xs text-gray-500 mt-0.5">Jika data Anda valid, akun akan diaktifkan dan Anda bisa langsung login menggunakan NIK + password.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold text-sm border border-green-200">3</div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Mulai Gunakan Layanan</p>
                    <p class="text-xs text-gray-500 mt-0.5">Ajukan permohonan surat apa pun kapan saja tanpa perlu antre di kantor desa.</p>
                </div>
            </div>
        </div>

        <!-- Info Bantuan -->
        <div class="bg-blue-50/80 border border-blue-200 rounded-2xl p-4 text-sm text-blue-800">
            <p class="font-semibold mb-1">💡 Perlu bantuan?</p>
            <p class="font-light text-blue-700">Hubungi kantor Balai Desa Medini atau WhatsApp admin desa di <strong>0812-3456-7890</strong> untuk menanyakan status verifikasi akun Anda.</p>
        </div>

        <div class="pt-2">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-gradient-to-r from-green-600 to-emerald-500 text-white font-bold rounded-xl shadow-lg shadow-green-200 hover:shadow-xl hover:shadow-green-300 hover:-translate-y-0.5 transition-all duration-300">
                Kembali ke Halaman Login
            </a>
        </div>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-bounce-slow { animation: bounceSlow 2s ease-in-out infinite; }
    @keyframes bounceSlow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
</style>
@endsection
