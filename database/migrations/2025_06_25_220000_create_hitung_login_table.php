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
        Schema::create('hitung_login', function (Blueprint $table) {
            $table->id();
            $table->string('google_id');
            $table->string('bulan_tahun', 7);
            $table->boolean('is_login')->default(true);
            $table->timestamps();

            $table->foreign('google_id')->references('google_id')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitung_login');
    }
};
