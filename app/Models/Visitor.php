<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','email','phone','asal_daerah','purpose','notes',
        'photo_path','Institution','visit_date'
    ];

    protected $casts = ['visit_date' => 'datetime'];

    // <-- tambahkan ini supaya photo_url otomatis ikut di JSON
    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo_path) {
            return null;
        }
        
        // Pastikan storage link sudah dibuat
        // php artisan storage:link
        return asset('storage/' . $this->photo_path);
    }

    const PURPOSE_OPTIONS = [
    'sekretariat' => 'Sekretariat',
    'aplikasi_informatika' => 'Aplikasi Informatika',
    'persandian_keamanan_informasi' => 'Persandian & Keamanan Informasi',
    'informasi_komunikasi_publik' => 'Informasi dan Komunikasi Publik',
    'statistik' => 'Statistik',
];

}
