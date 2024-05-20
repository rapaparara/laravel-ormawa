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
        Schema::create('periode_kepengurusans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('ormawa_id');
            $table->foreign('periode_id')->references('id')->on('periodes');
            $table->foreign('ormawa_id')->references('id')->on('ormawas');
            $table->text('file_sk');
            $table->enum('status', ['belum', 'tolak', 'setujui']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_kepengurusans');
    }
};
