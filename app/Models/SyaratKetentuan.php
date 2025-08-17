<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratKetentuan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi penamaan
    protected $table = 'syarat_ketentuan';

    // Tentukan atribut yang bisa diisi (fillable)
    protected $fillable = [
        'syarat',
        'syarat_pintu',
        'status_deleted',
    ];

    // Tentukan tipe data untuk beberapa kolom
    protected $casts = [
        'status_deleted' => 'boolean',
    ];

    // Tentukan jika ada kolom yang ingin kamu manipulasi atau manipulasi default lainnya
    // Misalnya jika ada kolom yang butuh default value atau handling khusus
    protected static function booted()
    {
        static::creating(function ($syaratKetentuan) {
            // Misalnya jika ingin set default untuk kolom tertentu
            if (is_null($syaratKetentuan->status_deleted)) {
                $syaratKetentuan->status_deleted = false; // Set default false
            }
        });
    }
}
