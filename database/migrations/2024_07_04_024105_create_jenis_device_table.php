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
        Schema::create('jenis_device', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis');
            $table->text('deskripsi');
            $table->foreignId('category_device_id');
            $table->timestamps();

            $table->foreign('category_device_id')->references('id')->on('category_device')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_device');
    }
};
