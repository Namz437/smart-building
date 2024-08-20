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
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perusahaan_id')->nullable();
            $table->foreignId('lantai_id')->nullable();
            $table->string('nama_ruangan');
            $table->text('deskripsi');
            $table->string('ukuran');
            $table->timestamps();

            $table->foreign('perusahaan_id')->references('id')->on('perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('lantai_id')->references('id')->on('lantai')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
