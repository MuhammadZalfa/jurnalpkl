<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journal;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        
        // Get students with matching DUDI or directly supervised
        // Di DashboardController instructor
        $students = User::where(function($query) use ($currentUser) {
                $query->where('role', 'student') // atau 'siswa' tergantung setting Anda
                    ->where('status', 'active')
                    ->where(function($q) use ($currentUser) {
                        // Match by DUDI
                        $q->where('dudi', 'like', '%'.$currentUser->dudi.'%')
                            // Atau match by pembimbing
                            ->orWhere('pembimbing', $currentUser->id);
                    });
            })
            ->orderBy('name')
            ->get();
        
        $studentIds = $students->pluck('id');
        
        $recentJournals = Journal::whereIn('user_id', $studentIds)
                                ->with('user')
                                ->orderBy('date', 'desc')
                                ->limit(5)
                                ->get();
        
        $journalCount = Journal::whereIn('user_id', $studentIds)->count();
        $studentCount = $students->count();
        $pendingJournalCount = Journal::whereIn('user_id', $studentIds)
                                    ->where('status', 'pending')
                                    ->count();
        
        // Get recent attendances (unique to instructor dashboard)
        $recentAttendances = Attendance::whereIn('student_id', $studentIds)
                                    ->with('student')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('instructor.dashboard', [
            'students' => $students,
            'recentJournals' => $recentJournals,
            'journalCount' => $journalCount,
            'studentCount' => $studentCount,
            'pendingJournalCount' => $pendingJournalCount,
            'recentAttendances' => $recentAttendances,
            'instructorDudi' => $currentUser->dudi
        ]);
    }
}