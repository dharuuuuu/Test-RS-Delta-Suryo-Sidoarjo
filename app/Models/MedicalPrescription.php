<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalPrescription extends Model
{
    use HasFactory;

    // Nama tabel di database (jika tidak sesuai konvensi Laravel)
    protected $table = 'medical_prescriptions';

    // Primary key yang digunakan (karena custom)
    protected $primaryKey = 'id';

    // Jika ID bukan auto-increment default
    public $incrementing = true;

    // Jika primary key bukan tipe integer (opsional jika ingin UUID)
    protected $keyType = 'int';

    // Jika tidak ingin menggunakan timestamps (misalnya tidak ada created_at dan updated_at)
    public $timestamps = true;

    // Mass Assignment Protection (kolom yang bisa diisi secara massal)
    protected $fillable = [
        'id_inspection',
        'id_obat',
        'nama_obat',
        'jumlah',
    ];

    // Relationship ke model Inspection
    // Model MedicalPrescription.php
    public function inspection()
    {
        return $this->belongsTo(Inspection::class, 'id_inspection');
    }
}
