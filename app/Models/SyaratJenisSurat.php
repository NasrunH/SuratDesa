<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SyaratJenisSurat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'syarat_jenis_surat';
    protected $primaryKey = 'id_syarat_jenis_surat';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_syarat_jenis_surat', 'id_jenis_surat', 'nama_syarat', 'tipe_input', 'is_wajib', 'urutan'
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'id_jenis_surat');
    }
}
