<?php
// app/Models/AssessmentMonthly2.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentMonthly2 extends Model
{
    use HasFactory;

    protected $table = 'assessment_monthly_2';

    protected $fillable = [
        'assessment_id',
        // Soft Skills
        'attendance_weight', 'attendance_desc',
        'appearance_weight', 'appearance_desc',
        'commitment_weight', 'commitment_desc',
        'politeness_weight', 'politeness_desc',
        'initiative_weight', 'initiative_desc',
        'teamwork_weight', 'teamwork_desc',
        'discipline_weight', 'discipline_desc',
        'communication_weight', 'communication_desc',
        'social_care_weight', 'social_care_desc',
        'k3lh_weight', 'k3lh_desc',
        // Hard Skills
        'expertise_weight', 'expertise_desc',
        'innovation_weight', 'innovation_desc',
        'productivity_weight', 'productivity_desc',
        'tool_mastery_weight', 'tool_mastery_desc',
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