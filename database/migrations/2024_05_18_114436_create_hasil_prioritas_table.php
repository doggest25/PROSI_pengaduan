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
    Schema::create('hasil_prioritas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_jenis_pengaduan');
        $table->decimal('score', 8, 2);

        $table->foreign('id_jenis_pengaduan')->references('id_jenis_pengaduan')->on('jenis_pengaduan')->onDelete('cascade');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('hasil_prioritas');
}

};
