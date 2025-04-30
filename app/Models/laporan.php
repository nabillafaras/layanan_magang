<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'user_id',
        'jenis_laporan',
        'judul',
        'file_path',
        'keterangan',
        'status',
        'feedback',
        'periode_bulan',
        'sk_selesai',
        'sertifikat'
    ];

    /**
     * Mendapatkan user yang berhubungan dengan laporan
     */
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'user_id', 'id');
    }
}