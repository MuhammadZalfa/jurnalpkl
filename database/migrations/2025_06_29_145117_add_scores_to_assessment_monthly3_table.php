<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('assessment_monthly_3', function (Blueprint $table) {
            $table->float('soft_skills_score')->nullable()->after('tool_mastery_desc');
            $table->float('hard_skills_score')->nullable()->after('soft_skills_score');
            $table->float('final_score')->nullable()->after('hard_skills_score');
        });
    }

    public function down()
    {
        Schema::table('assessment_monthly_3', function (Blueprint $table) {
            $table->dropColumn(['soft_skills_score', 'hard_skills_score', 'final_score']);
        });
    }
};