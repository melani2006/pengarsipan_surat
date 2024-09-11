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
        Schema::create('lampirans', function (Blueprint $table) {
            $table->id();
            $table->string('path')->nullable();
            $table->string('Nama File');
            $table->string('Ekstensi')->default('pdf');
            $table->unsignedBigInteger('surat_id')->comment('ID Surat');
            $table->foreign('surat_id')->references('id')->on('surats')->onDelete('cascade');
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
        Schema::dropIfExists('lampirans');
    }
};