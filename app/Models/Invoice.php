<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Nama tabel di database (jika tidak sesuai konvensi Laravel)
    protected $table = 'invoices';

    // Primary key yang digunakan (karena custom)
    protected $primaryKey = 'id_invoice';

    // Jika ID bukan auto-increment default
    public $incrementing = true;

    // Jika primary key bukan tipe integer (opsional jika ingin UUID)
    protected $keyType = 'int';

    // Jika tidak ingin menggunakan timestamps (misalnya tidak ada created_at dan updated_at)
    public $timestamps = true;

    // Mass Assignment Protection (kolom yang bisa diisi secara massal)
    protected $fillable = [
        'id_inspection',
        'total_harga',
        'total_bayar',
        'total_dibayar',
        'total_kembalian',
    ];

    // Cast tipe data agar otomatis dikonversi ke tipe yang sesuai
    protected $casts = [
        'total_harga' => 'integer',
        'total_bayar' => 'integer',
        'total_dibayar' => 'integer',
        'total_kembalian' => 'integer',
    ];

    // Relationship ke model Inspection
    public function inspection()
    {
        return $this->belongsTo(Inspection::class, 'id_inspection', 'id_inspection');
    }
}
