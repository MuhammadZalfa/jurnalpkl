<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessment_monthly_3', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->onDelete('cascade');
            
            // Soft Skills
            $table->integer('attendance_score')->default(0);
            $table->text('attendance_desc')->nullable();
            $table->integer('appearance_score')->default(0);
            $table->text('appearance_desc')->nullable();
            $table->integer('commitment_score')->default(0);
            $table->text('commitment_desc')->nullable();
            $table->integer('politeness_score')->default(0);
            $table->text('politeness_desc')->nullable();
            $table->integer('initiative_score')->default(0);
            $table->text('initiative_desc')->nullable();
            $table->integer('teamwork_score')->default(0);
            $table->text('teamwork_desc')->nullable();
            $table->integer('discipline_score')->default(0);
            $table->text('discipline_desc')->nullable();
            $table->integer('communication_score')->default(0);
            $table->text('communication_desc')->nullable();
            $table->integer('social_care_score')->default(0);
            $table->text('social_care_desc')->nullable();
            $table->integer('k3lh_score')->default(0);
            $table->text('k3lh_desc')->nullable();
            
            // Hard Skills
            $table->integer('expertise_score')->default(0);
            $table->text('expertise_desc')->nullable();
            $table->integer('innovation_score')->default(0);
            $table->text('innovation_desc')->nullable();
            $table->integer('productivity_score')->default(0);
            $table->text('productivity_desc')->nullable();
            $table->integer('tool_mastery_score')->default(0);
            $table->text('tool_mastery_desc')->nullable();
            
            // Entrepreneurship
            $table->integer('project_completion_score')->default(0);
            $table->text('project_completion_desc')->nullable();
            $table->integer('planning_score')->default(0);
            $table->text('planning_desc')->nullable();
            $table->integer('process_score')->default(0);
            $table->text('process_desc')->nullable();
            $table->integer('result_score')->default(0);
            $table->text('result_desc')->nullable();
            $table->integer('value_score')->default(0);
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
        Schema::dropIfExists('assessment_monthly_3');
    }
};