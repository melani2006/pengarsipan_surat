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
        Schema::create('disposisis', function (Blueprint $table) {
            $table->id();
            $table->string('to')->comment('penerima');
            $table->date('due_date')->comment('Tanggal Jatuh Tempo');
            $table->text('content')->comment('Isi');
            $table->text('Catatan')->nullable();
            $table->foreignId('status_surat')->constrained('status_surats', 'id')->cascadeOnDelete()->comment('Status Surat');
            $table->foreignId('surat_id')->constrained('surats')->cascadeOnDelete()->comment('ID Surat');
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->comment('ID Pengguna');
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
        Schema::dropIfExists('disposisis');
    }
};
