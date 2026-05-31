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
        Schema::create('penghuni_rumah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumah_id')->constrained('rumah')->onDelete('cascade');
            $table->foreignId('penghuni_id')->constrained('penghuni')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date')->nullable();     // null = masih tinggal sekarang
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghuni_rumah');
    }
};
