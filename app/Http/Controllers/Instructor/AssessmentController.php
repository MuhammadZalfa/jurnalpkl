<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentMonthly1;
use App\Models\AssessmentMonthly2;
use App\Models\AssessmentMonthly3;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;

class AssessmentController extends Controller
{
    use AuthorizesRequests;

    protected const ASSESSMENT_PERIODS = [
        'monthly1' => [
            'start' => '2025-07-15',
            'end' => '2025-07-30',
            'name' => 'Assessment Awal'
        ],
        'monthly2' => [
            'start' => '2025-09-15',
            'end' => '2025-09-30',
            'name' => 'Assessment Tengah'
        ],
        'monthly3' => [
            'start' => '2025-12-01',
            'end' => '2025-12-15',
            'name' => 'Assessment Akhir'
        ]
    ];

    protected function authorizeAssessment(Assessment $assessment)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->role !== 'instructor') {
            abort(403, 'Unauthorized action. Only instructors can access this.');
        }
        
        $validStudentIds = User::where('role', 'student')
            ->where('status', 'active')
            ->where(function($query) use ($currentUser) {
                $query->where('dudi', 'like', '%'.$currentUser->dudi.'%')
                    ->orWhere('pembimbing', $currentUser->id);
            })
            ->pluck('id')
            ->toArray();
        
        if (!in_array($assessment->student_id, $validStudentIds)) {
            abort(403, 'Unauthorized action. This assessment does not belong to your DUDI or supervised students.');
        }
        
        if ($assessment->student->status !== 'active') {
            abort(403, 'Student is not active.');
        }
        
        // Check if assessment is within the allowed period (including grace period)
        $period = self::ASSESSMENT_PERIODS[$assessment->type] ?? null;
        if ($period && Carbon::now()->gt(Carbon::parse($period['end'])->addDays(3))) {
            abort(403, 'Assessment period has ended and can no longer be updated.');
        }
    }

    // Constants for skill types
        protected const SOFT_SKILLS = [
        'Kehadiran' => 'attendance',
        'Penampilan' => 'appearance',
        'Komitmen' => 'commitment',
        'Sopan Santun' => 'politeness',
        'Inisiatif' => 'initiative',
        'Kerja Sama' => 'teamwork',
        'Disiplin' => 'discipline',
        'Komunikasi' => 'communication',
        'Kepedulian Sosial' => 'social_care',
        'K3LH' => 'k3lh'
    ];


    protected const HARD_SKILLS = [
        'Keahlian' => 'expertise',
        'Inovasi' => 'innovation',
        'Produktivitas' => 'productivity',
        'Penguasaan Alat' => 'tool_mastery'
    ];

    protected const ENTREPRENEURSHIP = [
        'Penyelesaian Proyek' => 'project_completion',
        'Perencanaan' => 'planning',
        'Proses' => 'process',
        'Hasil' => 'result',
        'Nilai' => 'value'
    ];

    /**
     * Display a listing of the assessments.
     */
    public function index()
    {
        $currentUser = Auth::user();
        
        $studentIds = User::where('role', 'student')
            ->where('status', 'active')
            ->where(function($query) use ($currentUser) {
                $query->where('dudi', 'like', '%'.$currentUser->dudi.'%')
                    ->orWhere('pembimbing', $currentUser->id);
            })
            ->pluck('id');
        
        $assessments = Assessment::with(['student', 'monthly1', 'monthly2', 'monthly3'])
            ->whereIn('student_id', $studentIds)
            ->orderBy('due_date', 'desc')
            ->paginate(10);

        // Update due dates for existing assessments
        foreach ($assessments as $assessment) {
            if ($assessment->type && isset(self::ASSESSMENT_PERIODS[$assessment->type])) {
                $assessment->due_date = self::ASSESSMENT_PERIODS[$assessment->type]['end'];
                $assessment->save();
            }
        }

        $validDudis = [$currentUser->dudi];
        if ($currentUser->additional_dudis) {
            $validDudis = array_merge($validDudis, explode(',', $currentUser->additional_dudis));
        }

        return view('instructor.assessments.index', [
            'assessments' => $assessments,
            'currentDudi' => $currentUser->dudi,
            'validDudis' => $validDudis,
            'today' => Carbon::now(),
            'assessmentPeriods' => self::ASSESSMENT_PERIODS
        ]);
    }
    /**
     * Show the form for Monthly 1 assessment.
     */
    public function showMonthly1(Assessment $assessment)
    {
        $this->authorizeAssessment($assessment);

        if (!$assessment->monthly1) {
            $assessment->monthly1()->create(['assessment_id' => $assessment->id]);
            $assessment->load('monthly1');
        }

        return view('instructor.assessments.assesment1-instructor', [
            'assessment' => $assessment->load(['monthly1', 'student']),
            'softSkills' => self::SOFT_SKILLS,
            'hardSkills' => self::HARD_SKILLS,
            'today' => Carbon::now()
        ]);
    }


    /**
     * Update Monthly 1 assessment.
     */
    public function updateMonthly1(Request $request, Assessment $assessment)
{
    $this->authorizeAssessment($assessment);

    $validator = Validator::make($request->all(), $this->getMonthly1ValidationRules());

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $validated = $validator->validated();
    
    // Prepare data for saving
    $dataToSave = [
        'dudi_comments' => $validated['dudi_comments'] ?? null,
        'dudi_approved' => $request->boolean('dudi_approved')
    ];

    // Process soft skills
    $softSkillsTotal = 0;
    foreach (self::SOFT_SKILLS as $field) {
        $dataToSave[$field] = $validated[$field];
        $dataToSave[$field.'_desc'] = $validated[$field.'_desc'] ?? null;
        $softSkillsTotal += $validated[$field];
    }

    // Process hard skills
    $hardSkillsTotal = 0;
    foreach (self::HARD_SKILLS as $field) {
        $dataToSave[$field] = $validated[$field];
        $dataToSave[$field.'_desc'] = $validated[$field.'_desc'] ?? null;
        $hardSkillsTotal += $validated[$field];
    }

    // Calculate scores
    $dataToSave['soft_skills_score'] = round($softSkillsTotal / count(self::SOFT_SKILLS), 2);
    $dataToSave['hard_skills_score'] = round($hardSkillsTotal / count(self::HARD_SKILLS), 2);
    $dataToSave['final_score'] = round(
        ($dataToSave['soft_skills_score'] * 0.6) + 
        ($dataToSave['hard_skills_score'] * 0.4), 
    2);

    // Update data
    $assessment->monthly1()->update($dataToSave);

    // Update assessment status
    $assessment->update([
        'status' => $dataToSave['dudi_approved'] ? 'approved' : 'pending',
        'dudi_reviewed_at' => $dataToSave['dudi_approved'] ? now() : null
    ]);

    return redirect()->route('instructor.assessments.index')
        ->with('success', 'Penilaian bulanan 1 berhasil diperbarui');
}


    /**
     * Show the form for Monthly 2 assessment.
     */
    public function showMonthly2(Assessment $assessment)
    {
        $this->authorizeAssessment($assessment);

        // Ensure monthly2 record exists
        if (!$assessment->monthly2) {
            $assessment->monthly2()->create(['assessment_id' => $assessment->id]);
            $assessment->load('monthly2');
        }

        return view('instructor.assessments.assesment2-instructor', [
            'assessment' => $assessment->load(['monthly2', 'student']),
            'softSkills' => self::SOFT_SKILLS,
            'hardSkills' => self::HARD_SKILLS,
            'today' => Carbon::now()
        ]);
    }

    /**
     * Update Monthly 2 assessment.
     */
    public function updateMonthly2(Request $request, Assessment $assessment)
    {
        $this->authorizeAssessment($assessment);

        $validator = Validator::make($request->all(), $this->getMonthly2ValidationRules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        
        // Extract approval status first
        $isApproved = $request->boolean('dudi_approved');
        unset($validated['dudi_approved']); // Remove from main data
        
        // Update monthly2 data
        $assessment->monthly2()->update($validated);
        
        // Update approval separately
        $assessment->monthly2()->update(['dudi_approved' => $isApproved]);

        // Update assessment status
        $assessment->update([
            'status' => $isApproved ? 'approved' : 'pending',
            'dudi_reviewed_at' => $isApproved ? now() : null
        ]);

        return redirect()->route('instructor.assessments.index')
            ->with('success', 'Penilaian bulanan 2 berhasil diperbarui');
    }

    /**
     * Show the form for Monthly 3 assessment.
     */
    public function showMonthly3(Assessment $assessment)
    {
        $this->authorizeAssessment($assessment);

        // Ensure monthly3 record exists
        if (!$assessment->monthly3) {
            $assessment->monthly3()->create(['assessment_id' => $assessment->id]);
            $assessment->load('monthly3');
        }

        return view('instructor.assessments.assesment3-instructor', [
            'assessment' => $assessment->load(['monthly3', 'student']),
            'softSkills' => self::SOFT_SKILLS,
            'hardSkills' => self::HARD_SKILLS,
            'entrepreneurship' => self::ENTREPRENEURSHIP,
            'today' => Carbon::now()
        ]);
    }

    /**
     * Update Monthly 3 assessment.
     */
    public function updateMonthly3(Request $request, Assessment $assessment)
    {
        $this->authorizeAssessment($assessment);

        $validator = Validator::make($request->all(), $this->getMonthly3ValidationRules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $this->calculateTotalScore($validator->validated());
        
        // Extract approval status first
        $isApproved = $request->boolean('dudi_approved');
        unset($validated['dudi_approved']); // Remove from main data
        
        // Update monthly3 data
        $assessment->monthly3()->update($validated);
        
        // Update approval separately
        $assessment->monthly3()->update(['dudi_approved' => $isApproved]);

        // Update assessment status
        $assessment->update([
            'status' => $isApproved ? 'approved' : 'pending',
            'dudi_reviewed_at' => $isApproved ? now() : null
        ]);

        return redirect()->route('instructor.assessments.index')
            ->with('success', 'Penilaian bulanan 3 berhasil diperbarui');
    }

    /**
     * Get validation rules for Monthly 1 assessment.
     */
    protected function getMonthly1ValidationRules(): array
    {
        $rules = [
            'dudi_comments' => 'nullable|string|max:500',
            'dudi_approved' => 'nullable|boolean'
        ];

        foreach (self::SOFT_SKILLS as $field) {
            $rules[$field] = 'required|integer|min:0|max:100';
            $rules[$field.'_desc'] = 'nullable|string|max:255';
        }

        foreach (self::HARD_SKILLS as $field) {
            $rules[$field] = 'required|integer|min:0|max:100';
            $rules[$field.'_desc'] = 'nullable|string|max:255';
        }

        return $rules;
    }

    /**
     * Get validation rules for Monthly 2 assessment.
     */
    protected function getMonthly2ValidationRules(): array
    {
        $rules = [
            'dudi_comments' => 'nullable|string|max:500',
            'dudi_approved' => 'nullable|boolean'
        ];

        foreach (self::SOFT_SKILLS as $field) {
            $rules[$field.'_weight'] = 'required|integer|min:0|max:100';
            $rules[$field.'_desc'] = 'nullable|string|max:255';
        }

        foreach (self::HARD_SKILLS as $field) {
            $rules[$field.'_weight'] = 'required|integer|min:0|max:100';
            $rules[$field.'_desc'] = 'nullable|string|max:255';
        }

        return $rules;
    }

    /**
     * Get validation rules for Monthly 3 assessment.
     */
    protected function getMonthly3ValidationRules(): array
    {
        $rules = [
            'dudi_comments' => 'nullable|string|max:500',
            'dudi_approved' => 'nullable|boolean'
        ];

        foreach (self::SOFT_SKILLS as $field) {
            $rules[$field.'_score'] = 'required|integer|min:0|max:100';
            $rules[$field.'_desc'] = 'nullable|string|max:255';
        }

        foreach (self::HARD_SKILLS as $field) {
            $rules[$field.'_score'] = 'required|integer|min:0|max:100';
            $rules[$field.'_desc'] = 'nullable|string|max:255';
        }

        foreach (self::ENTREPRENEURSHIP as $field) {
            $rules[$field.'_score'] = 'required|integer|min:0|max:100';
            $rules[$field.'_desc'] = 'nullable|string|max:255';
        }

        return $rules;
    }

    /**
     * Calculate total score for Monthly 3 assessment.
     */
    protected function calculateTotalScore(array $data): array
    {
        $totalSoftSkills = 0;
        $totalHardSkills = 0;
        $totalEntrepreneurship = 0;

        foreach (self::SOFT_SKILLS as $field) {
            $totalSoftSkills += $data[$field.'_score'];
        }

        foreach (self::HARD_SKILLS as $field) {
            $totalHardSkills += $data[$field.'_score'];
        }

        foreach (self::ENTREPRENEURSHIP as $field) {
            $totalEntrepreneurship += $data[$field.'_score'];
        }

        $data['total_soft_skills'] = round($totalSoftSkills / count(self::SOFT_SKILLS), 2);
        $data['total_hard_skills'] = round($totalHardSkills / count(self::HARD_SKILLS), 2);
        $data['total_entrepreneurship'] = round($totalEntrepreneurship / count(self::ENTREPRENEURSHIP), 2);
        $data['final_score'] = round(
            ($data['total_soft_skills'] * 0.4) + 
            ($data['total_hard_skills'] * 0.4) + 
            ($data['total_entrepreneurship'] * 0.2),
            2
        );

        return $data;
    }

    /**
     * Check if assessment is editable (not past due date)
     */
    protected function isAssessmentEditable(Assessment $assessment): bool
    {
        return Carbon::now()->lte($assessment->due_date->addDays(3));
    }
}