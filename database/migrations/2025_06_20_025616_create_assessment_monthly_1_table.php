<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessment_monthly_1', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->onDelete('cascade');
            
            // Soft Skills
            $table->enum('attendance', ['Kurang', 'Cukup', 'Baik']);
            $table->text('attendance_desc')->nullable();
            $table->enum('appearance', ['Kurang', 'Cukup', 'Baik']);
            $table->text('appearance_desc')->nullable();
            $table->enum('commitment', ['Kurang', 'Cukup', 'Baik']);
            $table->text('commitment_desc')->nullable();
            $table->enum('manners', ['Kurang', 'Cukup', 'Baik']);
            $table->text('manners_desc')->nullable();
            $table->enum('initiative', ['Kurang', 'Cukup', 'Baik']);
            $table->text('initiative_desc')->nullable();
            $table->enum('teamwork', ['Kurang', 'Cukup', 'Baik']);
            $table->text('teamwork_desc')->nullable();
            $table->enum('discipline', ['Kurang', 'Cukup', 'Baik']);
            $table->text('discipline_desc')->nullable();
            $table->enum('communication', ['Kurang', 'Cukup', 'Baik']);
            $table->text('communication_desc')->nullable();
            $table->enum('social_care', ['Kurang', 'Cukup', 'Baik']);
            $table->text('social_care_desc')->nullable();
            $table->enum('k3lh', ['Kurang', 'Cukup', 'Baik']);
            $table->text('k3lh_desc')->nullable();
            
            // Hard Skills
            $table->enum('expertise', ['Kurang', 'Cukup', 'Baik']);
            $table->text('expertise_desc')->nullable();
            $table->enum('innovation', ['Kurang', 'Cukup', 'Baik']);
            $table->text('innovation_desc')->nullable();
            $table->enum('productivity', ['Kurang', 'Cukup', 'Baik']);
            $table->text('productivity_desc')->nullable();
            $table->enum('tool_mastery', ['Kurang', 'Cukup', 'Baik']);
            $table->text('tool_mastery_desc')->nullable();
            
            // Entrepreneurship
            $table->enum('planning', ['Kurang', 'Cukup', 'Baik']);
            $table->text('planning_desc')->nullable();
            $table->enum('process', ['Kurang', 'Cukup', 'Baik']);
            $table->text('process_desc')->nullable();
            $table->enum('result', ['Kurang', 'Cukup', 'Baik']);
            $table->text('result_desc')->nullable();
            $table->enum('value', ['Kurang', 'Cukup', 'Baik']);
            $table->text('value_desc')->nullable();
            
            // Feedback
            $table->text('dudi_comments')->nullable();
            $table->text('pembimbing_comments')->nullable();
            $table->boolean('dudi_approved')->default(false);
            $table->boolean('pembimbing_approved')->default(false);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assessment_monthly_1');
    }
};