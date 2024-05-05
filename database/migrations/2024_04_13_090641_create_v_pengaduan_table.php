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
        Schema::create('v_pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_jenis_pengaduan');
            $table->string('deskripsi');
            $table->string('bukti_foto');
            $table->unsignedBigInteger('id_status_pengaduan');

            $table->foreign('user_id')->references('user_id')->on('v_user');
            $table->foreign('id_jenis_pengaduan')->references('id_jenis_pengaduan')->on('jenis_pengaduan');
            $table->foreign('id_status_pengaduan')->references('id_status_pengaduan')->on('status_pengaduan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_pengaduan');
    }
};
