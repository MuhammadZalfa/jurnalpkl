<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'ni', 'password', 'jurusan', 'dudi', 
        'pembimbing', 'role', 'status', 'last_login_at', 'last_login_ip'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
        'last_login_at' => 'datetime'
    ];

    // Relationships
    public function attendances() {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function journals() {
        return $this->hasMany(Journal::class, 'user_id');
    }

    public function assessments() {
        return $this->hasMany(Assessment::class, 'student_id');
    }

    // Scope for getting students by matching DUDI
    public function scopeStudentsByDudi($query, $instructor)
    {
        // Clean the instructor's DUDI for matching
        $instructorDudi = strtolower(trim(preg_replace('/[^\w\s]/', '', $instructor->dudi)));
        
       return $query->where('role', 'student') // Sesuaikan dengan nilai di database
                    ->where('status', 'active')
                    ->where(function($q) use ($instructor, $instructorDudi) {
                        // Match by similar DUDI
                        $q->where(function($subQuery) use ($instructorDudi) {
                            $subQuery->whereRaw("LOWER(TRIM(dudi)) LIKE ?", ['%'.$instructorDudi.'%'])
                                    ->orWhereRaw("LOWER(TRIM(dudi)) LIKE ?", ['%'.str_replace(' ', '%', $instructorDudi).'%']);
                        })
                        // Or match by direct supervision
                        ->orWhere('pembimbing', $instructor->id);
                    });
    }

    // Extract important parts from DUDI name
    protected function extractDudiParts($dudi) {
        $cleaned = strtolower(trim($dudi));
        $cleaned = preg_replace('/[^\w\s]/', '', $cleaned);
        
        $commonWords = ['pt', 'cv', 'ud', 'motor', 'banjar', 'tunas', 'jaya'];
        $words = explode(' ', $cleaned);
        $keywords = array_diff($words, $commonWords);
        
        return array_filter($keywords, function($word) {
            return strlen($word) > 2;
        });
    }

    public function isPembimbing() {
        return $this->role === 'instructor' || $this->role === 'admin';
    }
}