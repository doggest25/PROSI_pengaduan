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
    Schema::create('v_user', function (Blueprint $table) {
        $table->id('user_id');
        $table->unsignedBigInteger('level_id');
        $table->string('username', 20)->unique();
        $table->string('nama', 100);
        $table->string('password');
        $table->string('ktp', 20)->unique();
        $table->string('alamat', 100);
        $table->string('telepon', 20);
        $table->timestamps();

        $table->foreign('level_id')->references('level_id')->on('v_level');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_user');
    }
};
