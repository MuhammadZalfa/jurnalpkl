<?php

// app/Policies/AssessmentPolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\Assessment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssessmentPolicy
{
    use HandlesAuthorization;

    // Cek apakah user bisa mengupdate assessment
    public function update(User $user, Assessment $assessment)
    {
        // Student hanya bisa mengupdate assessment mereka sendiri yang masih pending
        if ($user->role === 'student') {
            return $assessment->student_id === $user->id && $assessment->status === 'pending';
        }
        
        // Pembimbing bisa mengupdate assessment siswa mereka
        if ($user->role === 'instructor') {
            return $assessment->pembimbing_name === $user->name;
        }
        
        // DUDI bisa mengupdate assessment siswa di tempat mereka
        if ($user->dudi) {
            return $assessment->dudi_name === $user->dudi;
        }
        
        // Admin bisa mengupdate semua assessment
        return $user->role === 'admin';
    }

    // Cek apakah user bisa approve sebagai DUDI
    public function approveAsDudi(User $user, Assessment $assessment)
    {
        // Hanya DUDI terkait atau admin yang bisa approve
        return ($user->dudi && $assessment->dudi_name === $user->dudi) || 
               $user->role === 'admin';
    }

    // Cek apakah user bisa approve sebagai Pembimbing
    public function approveAsPembimbing(User $user, Assessment $assessment)
    {
        // Hanya pembimbing terkait atau admin yang bisa approve
        return ($user->role === 'instructor' && $assessment->pembimbing_name === $user->name) || 
               $user->role === 'admin';
    }
}