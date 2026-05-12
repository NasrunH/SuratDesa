@php
    $colors = [
        'menunggu_verifikasi' => ['bg' => 'bg-yellow-100',  'text' => 'text-yellow-800',  'dot' => 'bg-yellow-500',  'border' => 'border-yellow-200',  'label' => 'Menunggu Verifikasi'],
        'revisi'              => ['bg' => 'bg-orange-100',  'text' => 'text-orange-800',  'dot' => 'bg-orange-500',  'border' => 'border-orange-200',  'label' => 'Perlu Revisi'],
        'menunggu_persetujuan'=> ['bg' => 'bg-blue-100',   'text' => 'text-blue-800',    'dot' => 'bg-blue-500',    'border' => 'border-blue-200',    'label' => 'Menunggu TTE'],
        'disetujui'           => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'dot' => 'bg-emerald-500', 'border' => 'border-emerald-200', 'label' => 'Disetujui'],
        'selesai'             => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'dot' => 'bg-emerald-500', 'border' => 'border-emerald-200', 'label' => 'Selesai'],
        'ditolak'             => ['bg' => 'bg-red-100',    'text' => 'text-red-800',     'dot' => 'bg-red-500',     'border' => 'border-red-200',     'label' => 'Ditolak'],
    ];
    $c = $colors[$status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'dot' => 'bg-slate-400', 'border' => 'border-slate-200', 'label' => ucfirst($status)];
@endphp
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $c['bg'] }} {{ $c['text'] }} border {{ $c['border'] }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $c['dot'] }} {{ in_array($status, ['revisi','menunggu_verifikasi']) ? 'animate-pulse' : '' }}"></span>
    {{ $c['label'] }}
</span>
