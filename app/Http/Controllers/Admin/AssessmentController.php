<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\User;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
        public function index()
    {   
        $instructorId = auth()->id();
        
        // Get all assessments where instructor_id matches current user
        $assessments = Assessment::with(['student', 'monthly1', 'monthly2', 'monthly3'])
            ->where('instructor_id', $instructorId)
            ->get();
            
        return view('admin.assesment-guru', compact('assessments'));
    }

    public function show($id)
    {
        $assessment = Assessment::with(['student', 'monthly1', 'monthly2', 'monthly3'])
            ->findOrFail($id);
            
        return view('admin.assesment-guru-detail', compact('assessment'));
    }
}