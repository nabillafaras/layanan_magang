<?php  
namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;  

class Pengumuman extends Model 
{
    use HasFactory;
      
    protected $table = 'pengumuman';
    protected $fillable = [
        'title',
        'content', // untuk input gambar atau video
        'isi',
        'status',       
        'attachment',      
        'admin_id',
        'published_at',
        'kategori' // Tambahan kolom kategori
    ];
      
    protected $casts = [
        'published_at' => 'datetime',
    ];
      
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
      
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}