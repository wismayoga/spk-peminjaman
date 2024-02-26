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
        Schema::create('jenis_variabels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_variabel');
            $table->string('nama');
            $table->timestamps();

            $table->foreign('id_variabel')->references('id')->on('variabels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_variabels');
    }
};
