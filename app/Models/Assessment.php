<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'dudi_name',
        'pembimbing_name',
        'type',
        'due_date',
        'status',
        'dudi_feedback',
        'pembimbing_feedback',
        'dudi_reviewed_at',
        'pembimbing_reviewed_at'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'dudi_reviewed_at' => 'datetime',
        'pembimbing_reviewed_at' => 'datetime'
    ];

    // Relasi dengan student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relasi dengan monthly1
    public function monthly1(): HasOne
    {
        return $this->hasOne(AssessmentMonthly1::class, 'assessment_id');
    }

    // Relasi dengan monthly2
    public function monthly2(): HasOne
    {
        return $this->hasOne(AssessmentMonthly2::class, 'assessment_id');
    }

    // Relasi dengan monthly3
    public function monthly3(): HasOne
    {
        return $this->hasOne(AssessmentMonthly3::class, 'assessment_id');
    }

    // Scope untuk assessment by type
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Cek apakah sudah di-approve DUDI
    public function isApprovedByDudi()
    {
        return $this->status === 'approved' || 
               ($this->type === 'monthly1' && $this->monthly1?->dudi_approved) ||
               ($this->type === 'monthly2' && $this->monthly2?->dudi_approved) ||
               ($this->type === 'monthly3' && $this->monthly3?->dudi_approved);
    }

    // Cek apakah sudah di-approve Pembimbing
    public function isApprovedByPembimbing()
    {
        return $this->status === 'approved' || 
               ($this->type === 'monthly1' && $this->monthly1?->pembimbing_approved) ||
               ($this->type === 'monthly2' && $this->monthly2?->pembimbing_approved) ||
               ($this->type === 'monthly3' && $this->monthly3?->pembimbing_approved);
    }
}