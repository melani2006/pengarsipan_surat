<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('nomor_agenda');
            $table->string('pengirim')->nullable();
            $table->string('penerima')->nullable();
            $table->date('Tanggal_Surat')->nullable();
            $table->date('Tanggal_Diterima')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('Catatan');
            $table->string('type')->default('incoming')->comment('Jenis Surat (incoming/outgoing)');
            $table->string('kategoris_code');
            $table->foreign('kategoris_code')->references('code')->on('kategoris')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Balikkan migration.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};