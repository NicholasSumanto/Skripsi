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
        Schema::create('sub_unit', function (Blueprint $table) {
            $table->id('id_sub_unit');
            $table->unsignedBigInteger('id_unit');
            $table->string('nama_sub_unit');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('id_unit')->references('id_unit')->on('unit')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_unit');
    }
};
