<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Assessment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssessmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Assessment $assessment)
    {
        return $user->role === 'instructor' && 
            $assessment->student->dudi === $user->dudi;
    }


    public function create(User $user)
    {
        return $user->role === 'instructor';
    }

    public function update(User $user, Assessment $assessment)
    {
        return $user->role === 'instructor' && 
            $assessment->student->dudi === $user->dudi &&
            $assessment->student->status === 'active';
    }

    public function delete(User $user, Assessment $assessment)
    {
        return $user->role === 'admin' || $user->dudi === $assessment->student->dudi;
    }

    public function approveAsDudi(User $user, Assessment $assessment)
    {
        return ($user->dudi && $assessment->dudi_name === $user->dudi) || 
               $user->role === 'admin';
    }

    public function approveAsPembimbing(User $user, Assessment $assessment)
    {
        return ($user->role === 'instructor' && $assessment->pembimbing_name === $user->name) || 
               $user->role === 'admin';
    }
}