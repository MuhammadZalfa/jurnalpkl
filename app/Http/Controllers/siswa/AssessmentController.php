<?php

namespace App\Http\Controllers\siswa;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Assessment;
use App\Models\AssessmentMonthly1;
use App\Models\AssessmentMonthly2;
use App\Models\AssessmentMonthly3;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index()
    {
        $student = auth()->user();
        
        if (empty($student->instructor_id)) {
            Log::error('Instructor ID not found for student: '.$student->id);
            $defaultInstructor = User::where('role', 'admin')->first();
            $instructorId = $defaultInstructor ? $defaultInstructor->id : 1;
        } else {
            $instructorId = $student->instructor_id;
        }

        // Get assessments with hardcoded due dates
        $monthly1 = Assessment::where('student_id', $student->id)
                    ->where('type', 'monthly1')
                    ->first();
        
        if ($monthly1 && !$monthly1->due_date) {
            $monthly1->update(['due_date' => '2025-07-30']);
        }

        $monthly2 = Assessment::where('student_id', $student->id)
                    ->where('type', 'monthly2')
                    ->first();
        
        if ($monthly2 && !$monthly2->due_date) {
            $monthly2->update(['due_date' => '2025-09-30']);
        }

        $monthly3 = Assessment::where('student_id', $student->id)
                    ->where('type', 'monthly3')
                    ->first();
        
        if ($monthly3 && !$monthly3->due_date) {
            $monthly3->update(['due_date' => '2025-12-15']);
        }
        
        return view('siswa.assesment', compact('monthly1', 'monthly2', 'monthly3'));
    }

    public function showMonthly1($id)
    {
        $assessment = Assessment::with('monthly1')->findOrFail($id);
        $monthly1 = $assessment->monthly1;

        $softSkills = [
            'a. Kehadiran' => [
                'weight' => $monthly1->attendance ?? 0,
                'description' => $monthly1->attendance_desc ?? '-'
            ],
            'b. Penampilan dan Kerapihan pakaian' => [
                'weight' => $monthly1->appearance ?? 0,
                'description' => $monthly1->appearance_desc ?? '-'
            ],
            'c. Komitmen dan integritas dalam menjalankan POS' => [
                'weight' => $monthly1->commitment ?? 0,
                'description' => $monthly1->commitment_desc ?? '-'
            ],
            'd. Sopan Santun' => [
                'weight' => $monthly1->manners ?? 0,
                'description' => $monthly1->manners_desc ?? '-'
            ],
            'e. Inisiatif' => [
                'weight' => $monthly1->initiative ?? 0,
                'description' => $monthly1->initiative_desc ?? '-'
            ],
            'f. Kerjasama tim' => [
                'weight' => $monthly1->teamwork ?? 0,
                'description' => $monthly1->teamwork_desc ?? '-'
            ],
            'g. Disiplin dan Tanggungjawab' => [
                'weight' => $monthly1->discipline ?? 0,
                'description' => $monthly1->discipline_desc ?? '-'
            ],
            'h. Komunikasi' => [
                'weight' => $monthly1->communication ?? 0,
                'description' => $monthly1->communication_desc ?? '-'
            ],
            'i. Kepedulian terhadap sosial dan lingkungan' => [
                'weight' => $monthly1->social_care ?? 0,
                'description' => $monthly1->social_care_desc ?? '-'
            ],
            'j. K3LH' => [
                'weight' => $monthly1->k3lh ?? 0,
                'description' => $monthly1->k3lh_desc ?? '-'
            ],
        ];

        $hardSkills = [
            'a. Keahlian dan keterampilan' => [
                'weight' => $monthly1->expertise ?? 0,
                'description' => $monthly1->expertise_desc ?? '-'
            ],
            'b. Inovasi dan kreativitas' => [
                'weight' => $monthly1->innovation ?? 0,
                'description' => $monthly1->innovation_desc ?? '-'
            ],
            'c. Produktivitas dan penyelesaian tugas' => [
                'weight' => $monthly1->productivity ?? 0,
                'description' => $monthly1->productivity_desc ?? '-'
            ],
            'd. Penguasaan penggunaan alat' => [
                'weight' => $monthly1->tool_mastery ?? 0,
                'description' => $monthly1->tool_mastery_desc ?? '-'
            ],
        ];

        $entrepreneurship = [
            'a. Perencanaan' => [
                'weight' => $monthly1->planning ?? 0,
                'description' => $monthly1->planning_desc ?? '-'
            ],
            'b. Proses' => [
                'weight' => $monthly1->process ?? 0,
                'description' => $monthly1->process_desc ?? '-'
            ],
            'c. Hasil' => [
                'weight' => $monthly1->result ?? 0,
                'description' => $monthly1->result_desc ?? '-'
            ],
            'd. Nilai Jual' => [
                'weight' => $monthly1->value ?? 0,
                'description' => $monthly1->value_desc ?? '-'
            ],
        ];

        return view('siswa.assesment1', compact(
            'assessment', 
            'softSkills', 
            'hardSkills', 
            'entrepreneurship'
        ));
    }

    public function showMonthly2($id)
    {
        $assessment = Assessment::with('monthly2')->findOrFail($id);
        $monthly2 = $assessment->monthly2;

        $softSkills = [
            'a. Kehadiran' => [
                'weight' => $monthly2->attendance_weight ?? 0,
                'description' => $monthly2->attendance_desc ?? '-'
            ],
            'b. Penampilan dan Kerapihan pakaian' => [
                'weight' => $monthly2->appearance_weight ?? 0,
                'description' => $monthly2->appearance_desc ?? '-'
            ],
            'c. Komitmen dan integritas dalam menjalankan POS' => [
                'weight' => $monthly2->commitment_weight ?? 0,
                'description' => $monthly2->commitment_desc ?? '-'
            ],
            'd. Sopan Santun' => [
                'weight' => $monthly2->politeness_weight ?? 0,
                'description' => $monthly2->politeness_desc ?? '-'
            ],
            'e. Inisiatif' => [
                'weight' => $monthly2->initiative_weight ?? 0,
                'description' => $monthly2->initiative_desc ?? '-'
            ],
            'f. Kerjasama tim' => [
                'weight' => $monthly2->teamwork_weight ?? 0,
                'description' => $monthly2->teamwork_desc ?? '-'
            ],
            'g. Disiplin dan Tanggungjawab' => [
                'weight' => $monthly2->discipline_weight ?? 0,
                'description' => $monthly2->discipline_desc ?? '-'
            ],
            'h. Komunikasi' => [
                'weight' => $monthly2->communication_weight ?? 0,
                'description' => $monthly2->communication_desc ?? '-'
            ],
            'i. kepedulian terhadap sosial dan lingkungan' => [
                'weight' => $monthly2->social_care_weight ?? 0,
                'description' => $monthly2->social_care_desc ?? '-'
            ],
            'j. K3LH' => [
                'weight' => $monthly2->k3lh_weight ?? 0,
                'description' => $monthly2->k3lh_desc ?? '-'
            ],
        ];

        $hardSkills = [
            'a. Keahlian dan keterampilan' => [
                'weight' => $monthly2->expertise_weight ?? 0,
                'description' => $monthly2->expertise_desc ?? '-'
            ],
            'b. Inovasi dan kreatifitas' => [
                'weight' => $monthly2->innovation_weight ?? 0,
                'description' => $monthly2->innovation_desc ?? '-'
            ],
            'c. produktivitas dan penyelesaian tugas' => [
                'weight' => $monthly2->productivity_weight ?? 0,
                'description' => $monthly2->productivity_desc ?? '-'
            ],
            'd. Penguasaan penggunaan alat' => [
                'weight' => $monthly2->tool_mastery_weight ?? 0,
                'description' => $monthly2->tool_mastery_desc ?? '-'
            ],
        ];

        return view('siswa.assesment2', compact(
            'assessment', 
            'softSkills', 
            'hardSkills'
        ));
    }

    public function showMonthly3($id)
    {
        $assessment = Assessment::with('monthly3')->findOrFail($id);
        $monthly3 = $assessment->monthly3;

        $softSkills = [
            'a. Kehadiran' => [
                'score' => $monthly3->attendance_score ?? 0,
                'description' => $monthly3->attendance_desc ?? '-'
            ],
            'b. Penampilan dan Kerapihan pakaian' => [
                'score' => $monthly3->appearance_score ?? 0,
                'description' => $monthly3->appearance_desc ?? '-'
            ],
            'c. Komitmen dan integritas dalam menjalankan POS' => [
                'score' => $monthly3->commitment_score ?? 0,
                'description' => $monthly3->commitment_desc ?? '-'
            ],
            'd. Sopan Santun' => [
                'score' => $monthly3->politeness_score ?? 0,
                'description' => $monthly3->politeness_desc ?? '-'
            ],
            'e. Inisiatif' => [
                'score' => $monthly3->initiative_score ?? 0,
                'description' => $monthly3->initiative_desc ?? '-'
            ],
            'f. Kerjasama tim' => [
                'score' => $monthly3->teamwork_score ?? 0,
                'description' => $monthly3->teamwork_desc ?? '-'
            ],
            'g. Disiplin dan Tanggungjawab' => [
                'score' => $monthly3->discipline_score ?? 0,
                'description' => $monthly3->discipline_desc ?? '-'
            ],
            'h. Komunikasi' => [
                'score' => $monthly3->communication_score ?? 0,
                'description' => $monthly3->communication_desc ?? '-'
            ],
            'i. kepedulian terhadap sosial dan lingkungan' => [
                'score' => $monthly3->social_care_score ?? 0,
                'description' => $monthly3->social_care_desc ?? '-'
            ],
            'j. K3LH' => [
                'score' => $monthly3->k3lh_score ?? 0,
                'description' => $monthly3->k3lh_desc ?? '-'
            ],
        ];

        $hardSkills = [
            'a. Keahlian dan keterampilan' => [
                'score' => $monthly3->expertise_score ?? 0,
                'description' => $monthly3->expertise_desc ?? '-'
            ],
            'b. Inovasi dan kreatifitas' => [
                'score' => $monthly3->innovation_score ?? 0,
                'description' => $monthly3->innovation_desc ?? '-'
            ],
            'c. produktivitas dan penyelesaian tugas' => [
                'score' => $monthly3->productivity_score ?? 0,
                'description' => $monthly3->productivity_desc ?? '-'
            ],
            'd. Penguasaan penggunaan alat' => [
                'score' => $monthly3->tool_mastery_score ?? 0,
                'description' => $monthly3->tool_mastery_desc ?? '-'
            ],
        ];

        $entrepreneurship = [
            'Kemampuan dalam menyelesaikan project' => [
                'score' => $monthly3->project_completion_score ?? 0,
                'description' => $monthly3->project_completion_desc ?? '-'
            ],
            'a. Perencanaan' => [
                'score' => $monthly3->planning_score ?? 0,
                'description' => $monthly3->planning_desc ?? '-'
            ],
            'b. Proses' => [
                'score' => $monthly3->process_score ?? 0,
                'description' => $monthly3->process_desc ?? '-'
            ],
            'c. Hasil' => [
                'score' => $monthly3->result_score ?? 0,
                'description' => $monthly3->result_desc ?? '-'
            ],
            'd. Nilai Jual' => [
                'score' => $monthly3->value_score ?? 0,
                'description' => $monthly3->value_desc ?? '-'
            ],
        ];

        return view('siswa.assesment3', compact(
            'assessment', 
            'softSkills', 
            'hardSkills', 
            'entrepreneurship'
        ));
    }
}