<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    const TYPE_PRESENT = 'masuk';
    const TYPE_SICK = 'sakit';
    const TYPE_PERMISSION = 'izin';

    protected $fillable = [
        'student_id',
        'date',
        'time_in',
        'time_out',
        'duration',
        'type',
        'reason',
        'notes'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['duration_formatted'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getDurationFormattedAttribute()
    {
        if (!$this->time_out) return '-';
        
        if ($this->duration === 0) {
            return 'kurang dari 1 menit';
        }
        
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return "{$hours} jam {$minutes} menit";
        } elseif ($hours > 0) {
            return "{$hours} jam";
        } else {
            return "{$minutes} menit";
        }
    }

    public function getTypeLabelAttribute()
    {
        return [
            self::TYPE_PRESENT => 'Masuk',
            self::TYPE_SICK => 'Sakit',
            self::TYPE_PERMISSION => 'Izin'
        ][$this->type] ?? $this->type;
    }

    public function getTypeBadgeClassAttribute()
    {
        return [
            self::TYPE_PRESENT => 'bg-green-100 text-green-800',
            self::TYPE_SICK => 'bg-yellow-100 text-yellow-800',
            self::TYPE_PERMISSION => 'bg-blue-100 text-blue-800'
        ][$this->type] ?? 'bg-gray-100 text-gray-800';
    }
}