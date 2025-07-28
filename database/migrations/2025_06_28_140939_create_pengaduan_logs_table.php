<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaduan_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengaduan_id');
            $table->string('keterangan'); // contoh: "Validasi", "Approve"
            $table->string('person');     // siapa yang melakukan
            $table->text('deskripsi')->nullable(); // deskripsi aksi
            $table->timestamps();

            // Foreign key ke tabel pengaduans
            $table->foreign('pengaduan_id')
                  ->references('id')->on('pengaduans')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan_logs');
    }
};
