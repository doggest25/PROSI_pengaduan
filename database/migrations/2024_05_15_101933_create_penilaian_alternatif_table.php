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
        Schema::create('penilaian_alternatif', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jenis_pengaduan');
            $table->unsignedBigInteger('kriteria_id');
            $table->decimal('nilai', 8, 4); // Nilai untuk kriteria pada alternatif tertentu

            $table->foreign('id_jenis_pengaduan')->references('id_jenis_pengaduan')->on('jenis_pengaduan')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('id')->on('kriteria')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_alternatif');
    }
};
