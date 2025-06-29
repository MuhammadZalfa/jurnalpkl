<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        
        // Get only students supervised by the current instructor/admin
        $students = User::where('role', 'student')
                    ->where('pembimbing', $currentUser->name)
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
        
        return view('admin.dashboard', [
            'students' => $students,
            'recentJournals' => $recentJournals,
            'journalCount' => $journalCount,
            'studentCount' => $studentCount,
            'pendingJournalCount' => $pendingJournalCount,
        ]);
    }
}