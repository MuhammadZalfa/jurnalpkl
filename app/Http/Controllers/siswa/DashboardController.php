<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Journal;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalJournals = Journal::where('user_id', $user->id)->count();
        $approvedJournals = Journal::where('user_id', $user->id)
                                 ->where('status', 'approved')
                                 ->count();
        $latestJournal = Journal::where('user_id', $user->id)
                              ->latest('date')
                              ->first();

        return view('siswa.dashboard', [ // updated view path
            'totalJournals' => $totalJournals,
            'approvedJournals' => $approvedJournals,
            'latestJournal' => $latestJournal
        ]);
    }
}
