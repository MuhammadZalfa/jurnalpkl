<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assessment_monthly_1', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_id');
            
            // Soft Skills
            $table->integer('attendance')->default(0);
            $table->text('attendance_desc')->nullable();
            $table->integer('appearance')->default(0);
            $table->text('appearance_desc')->nullable();
            $table->integer('commitment')->default(0);
            $table->text('commitment_desc')->nullable();
            $table->integer('politeness')->default(0);
            $table->text('politeness_desc')->nullable();
            $table->integer('initiative')->default(0);
            $table->text('initiative_desc')->nullable();
            $table->integer('teamwork')->default(0);
            $table->text('teamwork_desc')->nullable();
            $table->integer('discipline')->default(0);
            $table->text('discipline_desc')->nullable();
            $table->integer('communication')->default(0);
            $table->text('communication_desc')->nullable();
            $table->integer('social_care')->default(0);
            $table->text('social_care_desc')->nullable();
            $table->integer('k3lh')->default(0);
            $table->text('k3lh_desc')->nullable();
            
            // Hard Skills
            $table->integer('expertise')->default(0);
            $table->text('expertise_desc')->nullable();
            $table->integer('innovation')->default(0);
            $table->text('innovation_desc')->nullable();
            $table->integer('productivity')->default(0);
            $table->text('productivity_desc')->nullable();
            $table->integer('tool_mastery')->default(0);
            $table->text('tool_mastery_desc')->nullable();
            
            // Calculated Scores
            $table->decimal('soft_skills_score', 5, 2)->default(0);
            $table->decimal('hard_skills_score', 5, 2)->default(0);
            $table->decimal('final_score', 5, 2)->default(0);
            
            // Feedback
            $table->text('dudi_comments')->nullable();
            $table->text('pembimbing_comments')->nullable();
            $table->boolean('dudi_approved')->default(false);
            $table->boolean('pembimbing_approved')->default(false);
            
            $table->timestamps();
            
            // Foreign key
            $table->foreign('assessment_id')
                  ->references('id')
                  ->on('assessments')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('assessment_monthly_1');
    }
};