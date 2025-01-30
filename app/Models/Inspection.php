<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    // Nama tabel di database (jika tidak sesuai konvensi Laravel)
    protected $table = 'inspections';

    // Primary key yang digunakan (karena custom)
    protected $primaryKey = 'id_inspection';

    // Jika ID bukan auto-increment default
    public $incrementing = true;

    // Jika primary key bukan tipe integer (sebenarnya tetap bigInt, tapi bisa dipakai jika perlu UUID)
    protected $keyType = 'int';

    // Jika tidak ingin menggunakan timestamps (misalnya tidak ada created_at dan updated_at)
    public $timestamps = true;

    // Mass Assignment Protection (kolom yang bisa diisi secara massal)
    protected $fillable = [
        'nama_pasien',
        'tinggi_badan',
        'berat_badan',
        'systole',
        'diastole',
        'heart_rate',
        'respiration_rate',
        'suhu_tubuh',
        'hasil_pemeriksaan',
        'status',
    ];

    // Cast tipe data agar otomatis dikonversi ke tipe yang sesuai
    protected $casts = [
        'tinggi_badan' => 'decimal:2',
        'berat_badan' => 'decimal:2',
        'suhu_tubuh' => 'decimal:2',
    ];
}
