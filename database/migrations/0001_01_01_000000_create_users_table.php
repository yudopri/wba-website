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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('password');
            $table->string('profile_picture')->nullable();
            $table->enum('role', ['karyawan', 'head'])->default('karyawan');
            $table->boolean('verifikasi');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('email'); // Email of the user
            $table->string('token'); // Reset token
            $table->timestamp('created_at')->nullable(); // Timestamp for token creation
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade'); // Foreign key constraint
        });


        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    // Hapus foreign key constraint terlebih dahulu
    Schema::table('password_reset_tokens', function (Blueprint $table) {
        $table->dropForeign(['email']); // Drop foreign key constraint
    });

    // Hapus tabel-tabel
    Schema::dropIfExists('password_reset_tokens');
    Schema::dropIfExists('sessions');
    Schema::dropIfExists('users');
}

};
