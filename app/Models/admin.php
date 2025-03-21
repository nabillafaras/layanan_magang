<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'admins';

    protected $fillable = [
        'nama_lengkap',
        'username',
        'password',
        'email',
        'role',
    ];

    // Tentukan kolom yang digunakan untuk autentikasi
    public function getAuthIdentifierName()
    {
        return 'username'; 
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

    // Method helper untuk cek role
    public function isPimpinan()
    {
        return $this->role === 'pimpinan';
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
