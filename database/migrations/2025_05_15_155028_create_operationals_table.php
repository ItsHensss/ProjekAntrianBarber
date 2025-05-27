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
        Schema::create('operationals', function (Blueprint $table) {
            $table->id();
            $table->string('day'); // Hari operasional, misal: Senin, Selasa, dst
            $table->time('open_time'); // Jam buka
            $table->time('close_time'); // Jam tutup
            $table->boolean('is_open')->default(true); // Apakah toko buka di hari tersebut
            $table->unsignedBigInteger('tenant_id')->nullable(); // Relasi ke tenant, nullable jika tidak ada tenant yang terkait
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operationals');
    }
};