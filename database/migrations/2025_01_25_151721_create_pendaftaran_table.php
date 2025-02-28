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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 100);
            $table->string('ttl'); // Bisa diubah ke $table->date('ttl') jika hanya tanggal
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('no_hp', 15);
            $table->string('email', 100)->unique();
            $table->string('asal_universitas', 100);
            $table->string('jurusan', 100);
            $table->string('prodi', 100);
            $table->integer('semester');
            $table->decimal('ipk', 3, 2); // Format: total angka 3, 2 digit desimal
            $table->string('transkrip_nilai')->nullable(); // Kolom file bisa nullable
            $table->string('surat_pengantar')->nullable(); 
            $table->string('direktorat', 100);
            $table->string('unit_kerja', 100);
            $table->string('cv')->nullable(); // File CV
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran'); // Harus sesuai dengan nama tabel
    }
};
