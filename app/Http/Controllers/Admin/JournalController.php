<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index()
    {
        // Get supervised student IDs
        $studentIds = $this->getSupervisedStudentIds();
        
        // Get journals with pagination
        $journals = Journal::with('user')
                         ->whereIn('user_id', $studentIds)
                         ->orderBy('date', 'desc')
                         ->paginate(10);
        
        return view('admin.jurnal-guru', compact('journals'));
    }

    public function studentJournals($student_id)
    {
        // Pastikan siswa dibimbing oleh guru yang login
        $studentIds = $this->getSupervisedStudentIds();
        
        if (!$studentIds->contains($student_id)) {
            abort(403, 'Unauthorized action.');
        }

        $student = User::findOrFail($student_id);
        
        // Query jurnal - akan mengembalikan collection kosong jika tidak ada data
        $journals = Journal::where('user_id', $student_id)
                        ->orderBy('date', 'desc')
                        ->paginate(10);

        return view('admin.jurnal-siswa', compact('journals', 'student'));
    }
    
    public function show($id)
    {
        // Get supervised student IDs
        $studentIds = $this->getSupervisedStudentIds();
        
        $journal = Journal::with(['user', 'images'])
                        ->whereIn('user_id', $studentIds)
                        ->findOrFail($id);
        
        return view('admin.detail-jurnal-guru', compact('journal'));
    }
    
    public function approve(Request $request, $id)
    {
        // Get supervised student IDs
        $studentIds = $this->getSupervisedStudentIds();
        
        $journal = Journal::whereIn('user_id', $studentIds)
                        ->findOrFail($id);
        
        $journal->update([
            'status' => 'approved',
            'feedback' => $request->input('feedback', null)
        ]);
        
        return back()->with('success', 'Jurnal telah disetujui');
    }
    
    protected function getSupervisedStudentIds()
{
    $currentUser = Auth::user();
    return User::where('role', 'student')
             ->where('pembimbing', $currentUser->pembimbing)
             ->pluck('id');
}
}