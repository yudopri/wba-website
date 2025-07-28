<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kas_logistik', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->unsignedBigInteger('debit')->default(0);   // pemasukan
            $table->unsignedBigInteger('kredit')->default(0);  // pengeluaran
            $table->unsignedBigInteger('saldo_setelah');       // saldo sisa setelah transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_logistik');
    }
};

