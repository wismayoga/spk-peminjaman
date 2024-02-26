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
        Schema::create('aturans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rk');
            $table->unsignedBigInteger('id_penghasilan');
            $table->unsignedBigInteger('id_tanggungan');
            $table->unsignedBigInteger('id_jaminan');
            $table->string('hasil');
            $table->timestamps();

            $table->foreign('id_rk')->references('id')->on('himpunans')->onDelete('cascade');
            $table->foreign('id_penghasilan')->references('id')->on('himpunans')->onDelete('cascade');
            $table->foreign('id_tanggungan')->references('id')->on('himpunans')->onDelete('cascade');
            $table->foreign('id_jaminan')->references('id')->on('himpunans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturans');
    }
};
