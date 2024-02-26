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
        Schema::create('himpunans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_variabel');
            $table->unsignedBigInteger('id_kurva');
            $table->string('nama');
            $table->integer('a');
            $table->integer('b');
            $table->integer('c');
            $table->integer('d');
            $table->timestamps();

            $table->foreign('id_variabel')->references('id')->on('variabels')->onDelete('cascade');
            $table->foreign('id_kurva')->references('id')->on('kurvas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('himpunans');
    }
};
