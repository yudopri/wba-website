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
        // database/migrations/xxxx_xx_xx_xxxxxx_create_gajis_table.php
Schema::create('gajis', function (Blueprint $table) {
    $table->id();
    $table->string('nama_pt'); // ubah dari nama_karyawan ke nama_pt
    $table->bigInteger('nominal');
    $table->string('bulan');
    $table->string('status')->default('Menunggu');
    $table->timestamps();

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
