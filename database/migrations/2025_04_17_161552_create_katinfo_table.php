<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateKatinfoTable extends Migration
{
    public function up()
    {
        Schema::create('katinfo', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Tambahkan kategori default
        DB::table('katinfo')->insert([
            ['name' => 'Semua Direktorat', 'slug' => 'semua-direktorat', 'description' => 'Pengumuman untuk semua direktorat'],
            ['name' => 'Direktorat 1', 'slug' => 'direktorat-1', 'description' => 'Pengumuman khusus Direktorat 1'],
            ['name' => 'Direktorat 2', 'slug' => 'direktorat-2', 'description' => 'Pengumuman khusus Direktorat 2'],
            ['name' => 'Direktorat 3', 'slug' => 'direktorat-3', 'description' => 'Pengumuman khusus Direktorat 3'],
            ['name' => 'Direktorat 4', 'slug' => 'direktorat-4', 'description' => 'Pengumuman khusus Direktorat 4'],
            ['name' => 'Direktorat 5', 'slug' => 'direktorat-5', 'description' => 'Pengumuman khusus Direktorat 5'],
            ['name' => 'Home', 'slug' => 'home', 'description' => 'Pengumuman untuk halaman utama'],
            ['name' => 'Informasi Layanan', 'slug' => 'informasi-layanan', 'description' => 'Pengumuman terkait informasi layanan'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('katinfo');
    }
}