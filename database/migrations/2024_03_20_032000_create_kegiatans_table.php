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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ormawa_id');
            $table->unsignedBigInteger('kepengurusan_id');
            $table->foreign('ormawa_id')->references('id')->on('ormawas');
            $table->foreign('kepengurusan_id')->references('id')->on('periode_kepengurusans');
            $table->string('name');
            $table->longText('deskripsi');
            $table->date('waktu_mulai');
            $table->date('waktu_selesai');
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
