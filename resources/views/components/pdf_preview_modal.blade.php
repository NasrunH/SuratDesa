{{-- Modal Pratinjau Dokumen & Berkas Lampiran (PDF & Gambar) --}}
<div id="pdfPreviewModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="pdfModalTitle" role="dialog" aria-modal="true">
    <!-- Backdrop blur -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity cursor-pointer" onclick="closePdfPreview()"></div>

    <div class="flex min-h-screen items-center justify-center p-3 sm:p-4 text-center">
        <div class="relative w-full max-w-5xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all border border-slate-200 flex flex-col max-h-[92vh] z-10 animate-fade-in-up">
            
            <!-- Modal Header -->
            <div class="px-5 py-3.5 bg-slate-50 border-b border-slate-200 flex items-center justify-between gap-3 shrink-0">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div id="docModalIcon" class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="truncate">
                        <h3 class="text-sm font-bold text-gray-900 truncate" id="pdfModalTitle">Pratinjau Dokumen</h3>
                        <p class="text-xs text-gray-500 truncate" id="docModalSubtitle">Pratinjau berkas lampiran</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2 shrink-0">
                    <a id="pdfModalOpenTab" href="#" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition shadow-sm" title="Buka di tab baru">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span class="hidden sm:inline">Tab Baru</span>
                    </a>

                    <a id="pdfModalDownload" href="#" download class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-sm" title="Unduh Berkas">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span class="hidden sm:inline">Unduh</span>
                    </a>

                    <button type="button" onclick="closePdfPreview()" class="rounded-lg p-1.5 text-gray-400 hover:text-gray-600 hover:bg-slate-200 transition cursor-pointer" title="Tutup pratinjau (Esc)">
                        <span class="sr-only">Tutup</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body (Support both Image and PDF) -->
            <div class="relative flex-1 bg-slate-100 min-h-[420px] overflow-auto flex items-center justify-center p-2 sm:p-4">
                <!-- Loading indicator -->
                <div id="pdfModalLoading" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-50 z-20 transition-opacity duration-300">
                    <svg class="w-10 h-10 text-emerald-600 animate-spin mb-3" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <p class="text-sm font-semibold text-gray-700">Memuat Berkas...</p>
                    <p class="text-xs text-gray-400 mt-1" id="pdfModalLoadingSub">Menyiapkan pratinjau dokumen di halaman ini</p>
                </div>

                <!-- PDF Frame -->
                <iframe id="pdfPreviewFrame" src="" class="w-full h-[75vh] border-0 rounded-xl hidden bg-white shadow-sm" onload="onPdfIframeLoaded()"></iframe>

                <!-- Image Preview Container -->
                <div id="imagePreviewContainer" class="w-full h-full min-h-[400px] flex items-center justify-center overflow-auto p-2 hidden">
                    <img id="imagePreviewImg" src="" alt="Pratinjau Dokumen Lampiran" class="max-h-[73vh] max-w-full rounded-xl object-contain shadow-md border border-slate-300 bg-white" onload="onImageLoaded()" onerror="onImageError()">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.previewDocument = function(url, title, downloadUrl) {
    const modal = document.getElementById('pdfPreviewModal');
    const iframe = document.getElementById('pdfPreviewFrame');
    const imgContainer = document.getElementById('imagePreviewContainer');
    const img = document.getElementById('imagePreviewImg');
    const titleEl = document.getElementById('pdfModalTitle');
    const subEl = document.getElementById('docModalSubtitle');
    const tabLink = document.getElementById('pdfModalOpenTab');
    const dlLink = document.getElementById('pdfModalDownload');
    const loading = document.getElementById('pdfModalLoading');
    const loadingSub = document.getElementById('pdfModalLoadingSub');

    if (!modal) return;

    if (titleEl) titleEl.textContent = title ? title : 'Pratinjau Dokumen Lampiran';
    if (tabLink) tabLink.href = url;
    if (dlLink) {
        dlLink.href = downloadUrl || url;
    }

    if (loading) {
        loading.classList.remove('opacity-0', 'pointer-events-none');
    }

    // Tentukan apakah tipe file adalah Gambar atau PDF
    const cleanUrl = (url || '').split('?')[0].toLowerCase();
    const isImage = cleanUrl.endsWith('.jpg') || cleanUrl.endsWith('.jpeg') || cleanUrl.endsWith('.png') || cleanUrl.endsWith('.webp') || cleanUrl.endsWith('.gif') || cleanUrl.endsWith('.svg');

    if (isImage) {
        if (subEl) subEl.textContent = 'Berkas Gambar / Foto Lampiran';
        if (loadingSub) loadingSub.textContent = 'Memuat gambar lampiran...';
        if (iframe) {
            iframe.classList.add('hidden');
            iframe.src = 'about:blank';
        }
        if (imgContainer && img) {
            imgContainer.classList.remove('hidden');
            img.src = url;
        }
    } else {
        // Asumsi PDF atau dokumen cetak
        if (subEl) subEl.textContent = 'Berkas Dokumen PDF';
        if (loadingSub) loadingSub.textContent = 'Merender tata letak dokumen PDF...';
        if (imgContainer) imgContainer.classList.add('hidden');
        if (img) img.src = '';
        if (iframe) {
            iframe.classList.remove('hidden');
            iframe.src = url;
        }
    }

    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
};

// Aliases for full compatibility across the codebase
window.openPdfPreview = window.previewDocument;
window.previewFile = window.previewDocument;
window.previewImage = window.previewDocument;

window.previewLocalFile = function(input, title) {
    if (!input || !input.files || !input.files[0]) return;
    const file = input.files[0];
    const objectUrl = URL.createObjectURL(file);
    window.previewDocument(objectUrl, (title || 'Pratinjau Berkas') + ' (' + file.name + ')', objectUrl);
};

window.closePdfPreview = function() {
    const modal = document.getElementById('pdfPreviewModal');
    const iframe = document.getElementById('pdfPreviewFrame');
    const imgContainer = document.getElementById('imagePreviewContainer');
    const img = document.getElementById('imagePreviewImg');
    const loading = document.getElementById('pdfModalLoading');
    if (!modal) return;

    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    if (iframe) {
        iframe.src = 'about:blank';
        iframe.classList.add('hidden');
    }
    if (imgContainer) {
        imgContainer.classList.add('hidden');
    }
    if (img) {
        img.src = '';
    }
    if (loading) {
        loading.classList.remove('opacity-0', 'pointer-events-none');
    }
};

window.onPdfIframeLoaded = function() {
    const iframe = document.getElementById('pdfPreviewFrame');
    const loading = document.getElementById('pdfModalLoading');
    if (iframe && iframe.src && iframe.src !== 'about:blank' && loading) {
        loading.classList.add('opacity-0', 'pointer-events-none');
    }
};

window.onImageLoaded = function() {
    const loading = document.getElementById('pdfModalLoading');
    if (loading) {
        loading.classList.add('opacity-0', 'pointer-events-none');
    }
};

window.onImageError = function() {
    const loading = document.getElementById('pdfModalLoading');
    if (loading) {
        loading.classList.add('opacity-0', 'pointer-events-none');
    }
};

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        window.closePdfPreview();
    }
});
</script>
