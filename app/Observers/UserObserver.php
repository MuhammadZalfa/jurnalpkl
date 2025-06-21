<?php
// app/Observers/UserObserver.php
namespace App\Observers;

use App\Models\User;
use App\Models\Assessment;
use Carbon\Carbon;

class UserObserver
{
        public function created(User $user)
    {
        \Log::info('User created with role: ' . $user->role);
        if ($user->role === 'student') {
            $this->createAssessmentsForStudent($user);
        }
    }

    protected function createAssessmentsForStudent(User $student)
    {
        try {
            $assessments = [
                [
                    'type' => 'monthly1',
                    'due_date' => Carbon::now()->addMonth()
                ],
                [
                    'type' => 'monthly2',
                    'due_date' => Carbon::now()->addMonths(2)
                ],
                [
                    'type' => 'monthly3',
                    'due_date' => Carbon::now()->addMonths(3)
                ]
            ];

            foreach ($assessments as $assessment) {
                Assessment::create([
                    'student_id' => $student->id,
                    'dudi_name' => $student->dudi,
                    'pembimbing_name' => $student->pembimbing,
                    'type' => $assessment['type'],
                    'due_date' => $assessment['due_date'],
                    'status' => 'pending'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to create assessments: ' . $e->getMessage());
        }
    }
}