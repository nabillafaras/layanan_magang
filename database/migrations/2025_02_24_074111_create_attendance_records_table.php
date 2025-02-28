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
    Schema::create('attendance_records', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->date('date');
        $table->time('check_in_time')->nullable();
        $table->time('check_out_time')->nullable();
        $table->string('check_in_location');
        $table->string('check_out_location')->nullable();
        $table->string('check_in_photo')->nullable();
        $table->string('check_out_photo')->nullable();
        $table->decimal('check_in_latitude', 10, 8);
        $table->decimal('check_in_longitude', 11, 8);
        $table->decimal('check_out_latitude', 10, 8)->nullable();
        $table->decimal('check_out_longitude', 11, 8)->nullable();
        $table->string('status')->default('hadir'); // hadir, terlambat, izin, sakit
        $table->text('notes')->nullable();
        $table->string('ket_izin', 255) -> nullable();
        $table->string('bukti_izin')->nullable(); // File pendukung
        $table->string('ket_sakit', 255)-> nullable();
        $table->string('bukti_sakit')->nullable(); // File pendukung
        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
