<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kas_operasional', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->integer('debit')->default(0);
            $table->integer('kredit')->default(0);
            $table->integer('saldo_setelah')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kas_operasinoal');
    }
};
