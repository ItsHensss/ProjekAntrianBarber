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
        Schema::create('foto_interiors', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_interiors');
    }
};