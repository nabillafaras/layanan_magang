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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('jenis_laporan', ['bulanan', 'akhir']);
            $table->string('judul');
            $table->string('file_path');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->text('feedback')->nullable();
            $table->date('periode_bulan')->nullable(); // Untuk laporan bulanan
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('pendaftaran')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};