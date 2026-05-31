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
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->string('description');        // "Perbaikan jalan", "Gaji satpam", dll
            $table->bigInteger('amount');
            $table->integer('month');
            $table->integer('year');
            $table->date('expense_date');
            $table->boolean('is_recurring')->default(false);  // pengeluaran rutin atau tidak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
