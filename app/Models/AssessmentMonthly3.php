<?php
// app/Models/AssessmentMonthly3.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentMonthly3 extends Model
{
    use HasFactory;

    protected $table = 'assessment_monthly_3';

    protected $fillable = [
        'assessment_id',
        // Soft Skills
        'attendance_score', 'attendance_desc',
        'appearance_score', 'appearance_desc',
        'commitment_score', 'commitment_desc',
        'politeness_score', 'politeness_desc',
        'initiative_score', 'initiative_desc',
        'teamwork_score', 'teamwork_desc',
        'discipline_score', 'discipline_desc',
        'communication_score', 'communication_desc',
        'social_care_score', 'social_care_desc',
        'k3lh_score', 'k3lh_desc',
        // Hard Skills
        'expertise_score', 'expertise_desc',
        'innovation_score', 'innovation_desc',
        'productivity_score', 'productivity_desc',
        'tool_mastery_score', 'tool_mastery_desc',
        // Entrepreneurship
        'project_completion_score', 'project_completion_desc',
        'planning_score', 'planning_desc',
        'process_score', 'process_desc',
        'result_score', 'result_desc',
        'value_score', 'value_desc',
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