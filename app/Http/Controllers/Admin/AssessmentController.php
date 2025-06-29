<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentMonthly1;
use App\Models\AssessmentMonthly2;
use App\Models\AssessmentMonthly3;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
    {
        $studentIds = $this->getSupervisedStudentIds();
        
        $assessments = Assessment::with([
            'student', 
            'monthly1',
            'monthly2', // Nama relasi tetap sama
            'monthly3'
        ])
        ->whereIn('student_id', $studentIds)
        ->orderBy('student_id')
        ->get()
        ->groupBy('student_id');

        return view('admin.assesment-guru', compact('assessments'));
    }
    
    public function show($id)
    {
        $studentIds = $this->getSupervisedStudentIds();
        
        $assessment = Assessment::with(['student', 'monthly1', 'monthly2', 'monthly3'])
                            ->whereIn('student_id', $studentIds)
                            ->findOrFail($id);
        
        if (!$assessment->monthly1) {
            $assessment->setRelation('monthly1', new AssessmentMonthly1());
        }
        if (!$assessment->monthly2) {
            $assessment->setRelation('monthly2', new AssessmentMonthly2());
        }
        if (!$assessment->monthly3) {
            $assessment->setRelation('monthly3', new AssessmentMonthly3());
        }
        
        return view('admin.assesment-guru-detail', compact('assessment'));
    }

    public function addComment(Request $request, $assessmentId, $type)
    {
        $request->validate([
            'pembimbing_comments' => 'nullable|string|max:500'
        ]);

        $studentIds = $this->getSupervisedStudentIds();
        
        $assessment = Assessment::whereIn('student_id', $studentIds)
                              ->findOrFail($assessmentId);

        $monthly = null;
        switch($type) {
            case 'monthly1':
                $monthly = $assessment->monthly1;
                break;
            case 'monthly2':
                $monthly = $assessment->monthly2;
                break;
            case 'monthly3':
                $monthly = $assessment->monthly3;
                break;
        }

        if ($monthly) {
            $monthly->update(['pembimbing_comments' => $request->pembimbing_comments]);
            return back()->with('success', 'Komentar berhasil ' . ($request->pembimbing_comments ? 'diperbarui' : 'dihapus'));
        }

        return back()->with('error', 'Gagal menyimpan komentar');
    }
    
    protected function getSupervisedStudentIds()
    {
        $currentUser = Auth::user();
        return User::where('role', 'student')
                 ->where('pembimbing', $currentUser->pembimbing)
                 ->pluck('id');
    }
}