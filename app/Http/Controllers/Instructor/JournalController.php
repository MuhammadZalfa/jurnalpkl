<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    // Di JournalController.php
public function index()
{
    $instructor = auth()->user();
    
    // Gunakan query yang sama dengan DashboardController
    $students = User::where('role', 'student')
                  ->where('status', 'active')
                  ->where(function($q) use ($instructor) {
                      $q->where('dudi', 'like', '%'.$instructor->dudi.'%')
                        ->orWhere('pembimbing', $instructor->id);
                  })
                  ->pluck('id');
    
    $journals = Journal::whereIn('user_id', $students)
                     ->with('user')
                     ->latest()
                     ->paginate(10);
                     
    return view('instructor.journals.index', compact('journals'));
}
    
    public function show($journalId)
    {
        $journal = Journal::with(['user', 'images'])->findOrFail($journalId);
        
        return view('instructor.journals.show', [
            'journal' => $journal
        ]);
    }
    
    public function studentJournals($studentId)
    {
        $student = User::findOrFail($studentId);
        $journals = Journal::where('user_id', $studentId)
                         ->latest()
                         ->paginate(10);
                         
        return view('instructor.journals.student', [
            'student' => $student,
            'journals' => $journals
        ]);
    }
}