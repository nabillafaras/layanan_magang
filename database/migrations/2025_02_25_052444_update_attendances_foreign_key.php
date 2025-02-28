<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttendancesForeignKey extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Hapus foreign key yang ada
            $table->dropForeign('attendance_records_user_id_foreign');
            
            // Tambahkan foreign key baru yang mengarah ke pendaftaran.id
            $table->foreign('user_id')->references('id')->on('pendaftaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Hapus foreign key yang baru dibuat
            $table->dropForeign(['user_id']);
            
            // Kembalikan foreign key lama
            $table->foreign('user_id', 'attendance_records_user_id_foreign')
                ->references('id')->on('users')->onDelete('cascade');
        });
    }
}