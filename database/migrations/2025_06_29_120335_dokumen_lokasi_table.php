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
        Schema::create('dokumen_lokasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi');  // Nama lokasi kerja
            $table->string('nama_file');    // Nama file/dokumen
            $table->string('file_path');    // Path file yang disimpan di storage
            $table->timestamps();           // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_lokasi');
    }
};
