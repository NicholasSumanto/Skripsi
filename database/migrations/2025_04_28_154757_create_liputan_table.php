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
        Schema::create('liputan', function (Blueprint $table) {
            $table->id('id_liputan');
            $table->string('google_id');
            $table->unsignedBigInteger('id_sub_unit')->nullable();
            $table->string('id_proses_permohonan')->nullable();
            $table->char('id_verifikasi_publikasi', 60);
            $table->string('judul')->nullable();
            $table->enum('status_verifikasi', ['Tidak Terverifikasi', 'Terverifikasi']);
            $table->string('nama_pemohon');
            $table->string('nomor_handphone');
            $table->text('tempat')->nullable();
            $table->date('tanggal')->nullable();
            $table->dateTime('waktu')->nullable();
            $table->enum('wartawan', ['Ya', 'Tidak']);
            $table->string('file_liputan')->nullable();
            $table->string('output');
            $table->text('catatan')->nullable();
            $table->string('tautan_liputan')->nullable();
            $table->timestamps();

            $table->foreign('google_id')->references('google_id')->on('pengguna')->onDelete('cascade');
            $table->foreign('id_sub_unit')->references('id_sub_unit')->on('sub_unit')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_proses_permohonan')->references('id_proses_permohonan')->on('proses_permohonan')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liputan');
    }
};
