<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'due_date' => 'datetime:Y-m-d',
        'dudi_reviewed_at' => 'datetime',
        'pembimbing_reviewed_at' => 'datetime'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function monthly1(): HasOne
    {
        return $this->hasOne(AssessmentMonthly1::class, 'assessment_id');
    }

    public function monthly2(): HasOne
    {
        return $this->hasOne(AssessmentMonthly2::class, 'assessment_id');
    }

    public function monthly3(): HasOne
    {
        return $this->hasOne(AssessmentMonthly3::class, 'assessment_id');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function isApprovedByDudi(): bool
    {
        return $this->status === 'approved';
    }

    public function isApprovedByPembimbing(): bool
    {
        return $this->status === 'approved';
    }

    public function scopeForDudi($query, $dudiName)
    {
        return $query->whereHas('student', function($q) use ($dudiName) {
            $q->where('dudi', $dudiName);
        });
    }

    public function getDueDateRangeAttribute()
    {
        return match ($this->type) {
            'monthly1' => '15 - 30 Juli 2025',
            'monthly2' => '15 - 30 September 2025',
            'monthly3' => '1 - 15 Desember 2025',
            default => $this->due_date->format('d F Y')
        };
    }
}