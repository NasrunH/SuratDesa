<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisSurat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenis_surat';
    protected $primaryKey = 'id_jenis_surat';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_jenis_surat', 'nama_surat', 'deskripsi', 'thumbnail', 'template_path', 'template_konten', 'is_aktif'
    ];

    /**
     * URL thumbnail gambar surat dengan fallback ke gambar default sistem.
     */
    public function getThumbnailUrlAttribute(): string
    {
        if (!empty($this->thumbnail)) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->thumbnail)) {
                return asset('storage/' . $this->thumbnail);
            }
            if (\Illuminate\Support\Str::startsWith($this->thumbnail, ['http://', 'https://', 'images/'])) {
                return \Illuminate\Support\Str::startsWith($this->thumbnail, 'images/') ? asset($this->thumbnail) : $this->thumbnail;
            }
        }

        // Fallback cerdas berdasarkan nama surat
        $lowerName = \Illuminate\Support\Str::lower($this->nama_surat ?? '');
        if (\Illuminate\Support\Str::contains($lowerName, ['usaha', 'sku', 'dagang', 'bisnis', 'umkm'])) {
            if (file_exists(public_path('images/business_service.png'))) {
                return asset('images/business_service.png');
            }
        }

        if (file_exists(public_path('images/default_surat.png'))) {
            return asset('images/default_surat.png');
        }

        if (file_exists(public_path('images/social_service.png'))) {
            return asset('images/social_service.png');
        }

        return asset('images/logo.png');
    }

    /**
     * Memeriksa apakah jenis surat memiliki gambar thumbnail kustom yang terunggah.
     */
    public function hasCustomThumbnail(): bool
    {
        return !empty($this->thumbnail) && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->thumbnail);
    }

    public function syarat()
    {
        return $this->hasMany(SyaratJenisSurat::class, 'id_jenis_surat')->orderBy('urutan');
    }

    public function permohonanSurat()
    {
        return $this->hasMany(PermohonanSurat::class, 'id_jenis_surat');
    }
}
