@extends('layouts.app')

@section('title', 'Pilih Layanan Surat')

@section('content')
<div class="max-w-3xl mx-auto space-y-8 animate-fade-in-up">

    <div class="glass rounded-3xl p-8 border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20"></div>
        <div class="relative z-10 flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:text-green-600 hover:border-green-300 transition shadow-sm shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Pilih Layanan Surat</h1>
                <p class="text-gray-500 text-sm mt-0.5">Klik salah satu layanan di bawah untuk melanjutkan ke formulir pengisian.</p>
            </div>
        </div>
    </div>

    @if($jenisSurat->isEmpty())
        <div class="glass rounded-3xl p-12 text-center border border-white/50 shadow-sm">
            <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="text-gray-600 font-semibold text-lg">Belum ada layanan surat yang tersedia.</p>
            <p class="text-gray-400 text-sm mt-1">Hubungi petugas desa untuk informasi layanan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($jenisSurat as $js)
            {{-- Tiap card langsung link ke form/{id} --}}
            <a href="{{ route('warga.permohonan.form', $js->id_jenis_surat) }}"
               class="glass rounded-2xl p-6 border border-white/50 shadow-sm hover:shadow-lg hover:border-green-200 hover:-translate-y-1 transition-all duration-300 group cursor-pointer block relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-green-100 rounded-bl-full opacity-0 group-hover:opacity-60 transition-opacity"></div>
                <div class="flex items-start gap-4 relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-100 to-emerald-100 border border-green-200 flex items-center justify-center text-green-700 shrink-0 group-hover:from-green-200 group-hover:to-emerald-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-900 group-hover:text-green-700 transition-colors leading-tight">{{ $js->nama_surat }}</h3>
                        <p class="text-sm text-gray-500 mt-1 line-clamp-2 font-light leading-relaxed">{{ $js->deskripsi ?? 'Layanan surat administrasi resmi Desa Medini.' }}</p>
                        <div class="flex items-center gap-1 mt-3 text-xs font-semibold text-green-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            {{ $js->syarat->count() }} dokumen persyaratan
                        </div>
                    </div>
                    <div class="shrink-0 text-gray-300 group-hover:text-green-500 group-hover:translate-x-1 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s cubic-bezier(0.16,1,0.3,1) forwards; }
    @keyframes fadeInUp { from { opacity:0; transform:translateY(20px);} to {opacity:1; transform:translateY(0);} }
</style>
@endsection
