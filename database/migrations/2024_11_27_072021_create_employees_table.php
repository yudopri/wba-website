<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('keterangan')->nullable();
        $table->date('tmt')->nullable();
        $table->string('nik');
        $table->foreignId('departemen_id')->constrained('departemens')->onDelete('cascade'); // Tentukan tabel dengan huruf kecil
        $table->foreignId('jabatan_id')->constrained('jabatans')->onDelete('cascade');
        $table->foreignId('gada_id')->constrained('gadas')->onDelete('cascade');
        $table->string('tempat_lahir')->nullable();
        $table->date('ttl')->nullable();
        $table->string('telp')->nullable();
        $table->string('nik_ktp')->nullable();
        $table->string('pict_ktp')->nullable();
        $table->string('berlaku')->nullable();
        $table->string('status')->nullable();
        $table->string('pendidikan')->nullable();
        $table->string('pict_ijasah')->nullable();
        $table->string('email')->unique();
        $table->string('nama_ibu')->nullable();
        $table->string('sertifikat')->nullable();
        $table->string('no_regkta')->nullable();
        $table->string('pict_kta')->nullable();
        $table->string('alamat_ktp')->nullable();
        $table->string('alamat_domisili')->nullable();
        $table->string('bpjsket')->nullable();
        $table->string('pict_bpjsket')->nullable();
        $table->string('no_npwp')->nullable();
        $table->string('pict_npwp')->nullable();
        $table->enum('status_kerja', ['aktif', 'nonaktif', 'blacklist'])->default('aktif');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
