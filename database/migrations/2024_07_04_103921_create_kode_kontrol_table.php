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
        Schema::create('kode_kontrol', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merk_id');
            $table->longText('kode');
            $table->string('alias');
            $table->timestamps();

            $table->foreign('merk_id')->references('id')->on('merk')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_kontrol');
    }
};
