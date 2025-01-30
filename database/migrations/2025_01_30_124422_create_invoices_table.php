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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id_invoice');
            $table->unsignedBigInteger('id_inspection');
            $table->integer('total_harga');
            $table->integer('total_bayar');
            $table->integer('total_dibayar');
            $table->integer('total_kembalian');

            $table->timestamps();

            $table->foreign('id_inspection')->references('id_inspection')->on('inspections')->onUpdate('CASCADE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
