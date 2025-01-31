<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_pasien');
            $table->decimal('tinggi_badan', 10, 2);
            $table->decimal('berat_badan', 10, 2);
            $table->string('systole');
            $table->string('diastole');
            $table->string('heart_rate');
            $table->string('respiration_rate');
            $table->decimal('suhu_tubuh', 10, 2);
            $table->longText('hasil_pemeriksaan');
            $table->string('status');
            $table->date('tanggal_pemeriksaan');
            $table->longText('file_url');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
