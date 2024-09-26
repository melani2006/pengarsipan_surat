<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('nomor_riwayat');
            $table->string('pengirim')->nullable();
            $table->string('penerima')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->date('tanggal_diterima')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('catatan')->nullable();
            $table->string('type')->default('masuk')->comment('Surat Masuk (masuk)/Surat Keluar (keluar)');
            $table->string('kategori_code');
            $table->foreign('kategori_code')->references('code')->on('kategoris');
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};