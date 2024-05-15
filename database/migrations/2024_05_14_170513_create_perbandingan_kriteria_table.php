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
        Schema::create('perbandingan_kriteria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kriteria_1_id');
            $table->unsignedBigInteger('kriteria_2_id');
            $table->decimal('nilai_perbandingan', 5, 4);
            $table->timestamps();

            $table->foreign('kriteria_1_id')->references('id')->on('kriteria')->onDelete('cascade');
            $table->foreign('kriteria_2_id')->references('id')->on('kriteria')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perbandingan_kriteria');
    }
};
