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
        Schema::create('pembayaran_iuran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumah_id')->constrained('rumah');
            $table->foreignId('penghuni_id')->constrained('penghuni');
            $table->foreignId('jenis_iuran_id')->constrained('jenis_iuran');
            $table->integer('month');                 // 1-12
            $table->integer('year');
            $table->bigInteger('amount');
            $table->enum('status', ['lunas', 'belum'])->default('belum');
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_iuran');
    }
};
