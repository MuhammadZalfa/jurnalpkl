<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Assessment;
use Carbon\Carbon;

class GenerateMissingAssessments extends Command
{
    protected $signature = 'assessments:generate-missing';
    protected $description = 'Generate assessments for students who dont have any';

    public function handle()
    {
        // Ambil semua siswa yang belum memiliki assessment
        $studentsWithoutAssessments = User::where('role', 'student')
            ->whereDoesntHave('assessments')
            ->get();

        foreach ($studentsWithoutAssessments as $student) {
            $this->createAssessmentsForStudent($student);
            $this->info("Created assessments for student: {$student->name} (ID: {$student->id})");
        }

        $this->info("Completed! {$studentsWithoutAssessments->count()} students processed.");
    }

    protected function createAssessmentsForStudent($student)
    {
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
    }
}