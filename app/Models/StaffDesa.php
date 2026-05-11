<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffDesa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'staff_desa';
    protected $primaryKey = 'id_staff_desa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_staff_desa', 'id_penduduk', 'nip', 'jabatan'
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'id_penduduk');
    }
}
