<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Authenticatable
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'nama_lengkap',
        'ttl',
        'jenis_kelamin',
        'no_hp',
        'email',
        'asal_universitas',
        'jurusan',
        'prodi',
        'semester',
        'ipk',
        'transkrip_nilai',
        'surat_pengantar',
        'direktorat',
        'unit_kerja',
        'cv',
        'nomor_pendaftaran',
        'password',
        'status',
        'catatan',
        'surat_balasan',
        'role',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id', 'id');
    }
    protected $guard = 'web';
    // Tentukan kolom yang digunakan untuk autentikasi
    public function getAuthIdentifierName()
    {
        return 'nomor_pendaftaran'; // Menggunakan nomor_pendaftaran sebagai username
    }

    // Tentukan kolom yang digunakan untuk password
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Kolom password tidak perlu ter-expose
    protected $hidden = [
        'password',
    ];
}
