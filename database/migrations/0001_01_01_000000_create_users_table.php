<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ni', 20)->unique(); // Nomor Induk (unik)
            $table->string('password');
            $table->string('jurusan');
            $table->string('dudi'); // Tempat PKL
            $table->string('pembimbing');
            $table->enum('role', ['admin', 'instructor', 'student'])->default('student');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};