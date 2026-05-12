<?php

namespace App\Models;

// Menggunakan Authenticatable agar bisa digunakan oleh sistem Auth Laravel
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penduduk extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'penduduk';
    
    protected $primaryKey = 'id_penduduk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_penduduk',
        'nik',
        'password',
        'nama',
        'email',
        'no_hp',
        'alamat',
        'foto_ktp',
        'role',
        'status_akun',
        'catatan_penolakan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password'   => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // ---- Relasi ----
    public function staffDesa()
    {
        return $this->hasOne(StaffDesa::class, 'id_penduduk', 'id_penduduk');
    }

    public function kepalaDesa()
    {
        return $this->hasOne(KepalaDesa::class, 'id_penduduk', 'id_penduduk');
    }

    public function permohonanSurat()
    {
        return $this->hasMany(PermohonanSurat::class, 'id_penduduk', 'id_penduduk');
    }

    // ---- Helper Status ----
    public function isPending(): bool
    {
        return $this->status_akun === 'pending';
    }

    public function isAktif(): bool
    {
        return $this->status_akun === 'aktif';
    }
}