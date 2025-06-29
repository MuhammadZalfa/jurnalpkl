<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentMonthly1 extends Model
{
    use HasFactory;

    protected $table = 'assessment_monthly_1';

    protected $fillable = [
        'assessment_id',
        // Soft Skills
        'attendance', 'attendance_desc',
        'appearance', 'appearance_desc',
        'commitment', 'commitment_desc',
        'politeness', 'politeness_desc',
        'initiative', 'initiative_desc',
        'teamwork', 'teamwork_desc',
        'discipline', 'discipline_desc',
        'communication', 'communication_desc',
        'social_care', 'social_care_desc',
        'k3lh', 'k3lh_desc',
        // Hard Skills
        'expertise', 'expertise_desc',
        'innovation', 'innovation_desc',
        'productivity', 'productivity_desc',
        'tool_mastery', 'tool_mastery_desc',
        // Calculated scores
        'soft_skills_score',
        'hard_skills_score',
        'final_score',
        // Feedback
        'dudi_comments', 'pembimbing_comments',
        'dudi_approved', 'pembimbing_approved'
    ];

    protected $casts = [
        'dudi_approved' => 'boolean',
        'pembimbing_approved' => 'boolean',
        // Cast all score fields as integers
        'attendance' => 'integer',
        'appearance' => 'integer',
        'commitment' => 'integer',
        'politeness' => 'integer',
        'initiative' => 'integer',
        'teamwork' => 'integer',
        'discipline' => 'integer',
        'communication' => 'integer',
        'social_care' => 'integer',
        'k3lh' => 'integer',
        'expertise' => 'integer',
        'innovation' => 'integer',
        'productivity' => 'integer',
        'tool_mastery' => 'integer',
        // Cast calculated scores
        'soft_skills_score' => 'float',
        'hard_skills_score' => 'float',
        'final_score' => 'float'
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}