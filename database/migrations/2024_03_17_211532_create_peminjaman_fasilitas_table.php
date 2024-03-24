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
        Schema::create('peminjaman_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fasilitas_id');
            $table->unsignedBigInteger('ormawa_id');
            $table->foreign('fasilitas_id')->references('id')->on('fasilitas');
            $table->foreign('ormawa_id')->references('id')->on('ormawas');
            $table->text('file_surat')->nullable();
            $table->date('waktu_mulai');
            $table->date('waktu_selesai');
            $table->enum('status', ['belum', 'tolak', 'setujui']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_fasilitas');
    }
};
