<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proses_permohonan', function (Blueprint $table) {
            $table->string('id_proses_permohonan')->primary();
            $table->enum('status', ['Diajukan', 'Diterima', 'Batal', 'Diproses', 'Selesai']);
            $table->date('tanggal_diajukan')->nullable();
            $table->date('tanggal_diterima')->nullable();
            $table->date('tanggal_diproses')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('batal_is_pemohon')->nullable();
            $table->date('tanggal_batal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proses_permohonan');
    }
};
