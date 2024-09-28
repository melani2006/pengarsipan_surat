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
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verifikasi')->nullable();
            $table->string('password');
            $table->bigInteger('phone');
            $table->string('role')->default('staff');
            $table->boolean('is_active')->default(true);
            $table->string('foto_profile')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Balikkan migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
