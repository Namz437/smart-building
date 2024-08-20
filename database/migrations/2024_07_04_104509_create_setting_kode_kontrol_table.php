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
        Schema::create('setting_kode_kontrol', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mac_address');
            $table->foreignId('kode_kontrol_id');
            $table->timestamps();
            $table->foreign('kode_kontrol_id')->references('id')->on('kode_kontrol')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_kode_kontrol');
    }
};
