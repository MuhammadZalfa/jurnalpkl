<?php

// database/migrations/xxxx_xx_xx_create_assessments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('dudi_name'); // Nama DUDI tempat PKL
            $table->string('pembimbing_name'); // Nama pembimbing sekolah
            $table->enum('type', ['monthly1', 'monthly2', 'monthly3']);
            $table->dateTime('due_date');
            $table->enum('status', ['pending', 'completed', 'approved', 'rejected'])->default('pending');
            $table->text('dudi_feedback')->nullable(); // Feedback dari DUDI
            $table->text('pembimbing_feedback')->nullable(); // Feedback dari pembimbing
            $table->dateTime('dudi_reviewed_at')->nullable(); // Tanggal review DUDI
            $table->dateTime('pembimbing_reviewed_at')->nullable(); // Tanggal review pembimbing
            $table->timestamps();
            
            $table->index(['student_id', 'type']); // Index untuk pencarian cepat
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessments');
    }
};