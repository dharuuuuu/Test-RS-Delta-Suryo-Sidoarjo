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
        Schema::create('medical_prescriptions', function (Blueprint $table) {
            $table->bigIncrements('id_medicine');
            $table->unsignedBigInteger('id_inspection');
            $table->integer('harga');

            $table->timestamps();

            $table->foreign('id_inspection')->references('id_inspection')->on('inspections')->onUpdate('CASCADE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_prescriptions');
    }
};
