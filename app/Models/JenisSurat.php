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
        'id_jenis_surat', 'nama_surat', 'deskripsi', 'template_path', 'template_konten', 'is_aktif'
    ];

    public function syarat()
    {
        return $this->hasMany(SyaratJenisSurat::class, 'id_jenis_surat')->orderBy('urutan');
    }

    public function permohonanSurat()
    {
        return $this->hasMany(PermohonanSurat::class, 'id_jenis_surat');
    }
}
