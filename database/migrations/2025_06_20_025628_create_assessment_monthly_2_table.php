<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assessment_monthly_2', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->onDelete('cascade');
            
            // Soft Skills
            $table->integer('attendance_weight')->default(0);
            $table->text('attendance_desc')->nullable();
            $table->integer('appearance_weight')->default(0);
            $table->text('appearance_desc')->nullable();
            $table->integer('commitment_weight')->default(0);
            $table->text('commitment_desc')->nullable();
            $table->integer('politeness_weight')->default(0);
            $table->text('politeness_desc')->nullable();
            $table->integer('initiative_weight')->default(0);
            $table->text('initiative_desc')->nullable();
            $table->integer('teamwork_weight')->default(0);
            $table->text('teamwork_desc')->nullable();
            $table->integer('discipline_weight')->default(0);
            $table->text('discipline_desc')->nullable();
            $table->integer('communication_weight')->default(0);
            $table->text('communication_desc')->nullable();
            $table->integer('social_care_weight')->default(0);
            $table->text('social_care_desc')->nullable();
            $table->integer('k3lh_weight')->default(0);
            $table->text('k3lh_desc')->nullable();
            
            // Hard Skills
            $table->integer('expertise_weight')->default(0);
            $table->text('expertise_desc')->nullable();
            $table->integer('innovation_weight')->default(0);
            $table->text('innovation_desc')->nullable();
            $table->integer('productivity_weight')->default(0);
            $table->text('productivity_desc')->nullable();
            $table->integer('tool_mastery_weight')->default(0);
            $table->text('tool_mastery_desc')->nullable();
            
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
        Schema::dropIfExists('assessment_monthly_2');
    }
};