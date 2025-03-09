<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Attendance extends Model
{
    protected $table = 'attendances';
    public $timestamps = true;
    protected $fillable = [
        'user_id', 'date', 
        'check_in_time', 
        'check_out_time',
        'check_in_location', 
        'check_out_location',
        'check_in_photo', 
        'check_out_photo',
        'check_in_latitude', 
        'check_in_longitude',
        'check_out_latitude', 
        'check_out_longitude',
        'status', 
        'notes', 
        'ket_izin', 
        'bukti_izin', 
        'ket_sakit', 
        'bukti_sakit',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'user_id', 'id');
    }
}