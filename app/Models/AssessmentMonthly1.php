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
        'manners', 'manners_desc',
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
        // Entrepreneurship
        'planning', 'planning_desc',
        'process', 'process_desc',
        'result', 'result_desc',
        'value', 'value_desc',
        // Feedback
        'dudi_comments', 'pembimbing_comments',
        'dudi_approved', 'pembimbing_approved'
    ];

    protected $casts = [
        'dudi_approved' => 'boolean',
        'pembimbing_approved' => 'boolean'
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}