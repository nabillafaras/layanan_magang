<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katinfo extends Model
{
    use HasFactory;


    protected $table = 'katinfo';
    protected $fillable = ['name', 'slug', 'description'];

    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class);
    }
}