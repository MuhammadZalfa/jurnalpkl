<?php
// app/Http/Controllers/Instructor/AttendanceController.php
namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $instructor = auth()->user();
        
        // Menggunakan query yang konsisten dengan controller lainnya
        $students = User::where('role', 'student')
                      ->where('status', 'active')
                      ->where(function($q) use ($instructor) {
                          $q->where('dudi', 'like', '%'.$instructor->dudi.'%')
                            ->orWhere('pembimbing', $instructor->id);
                      })
                      ->pluck('id');
        
        $attendances = Attendance::whereIn('student_id', $students)
                              ->with('student')
                              ->latest()
                              ->paginate(10);
                              
        return view('instructor.attendances.index', [
            'attendances' => $attendances
        ]);

        if ($request->has('type')) {
        $attendances->where('type', $request->type);
    }
    
        return view('instructor.attendances.index', [
            'attendances' => $attendances->paginate(10),
            'types' => [
                '' => 'Semua',
                Attendance::TYPE_PRESENT => 'Masuk',
                Attendance::TYPE_SICK => 'Sakit',
                Attendance::TYPE_PERMISSION => 'Izin'
            ]
        ]);
    }
    
    public function show($studentId)
    {
        // Verifikasi bahwa siswa ini memang bimbingan instruktur
        $instructor = auth()->user();
        $student = User::where('id', $studentId)
                     ->where(function($q) use ($instructor) {
                         $q->where('dudi', 'like', '%'.$instructor->dudi.'%')
                           ->orWhere('pembimbing', $instructor->id);
                     })
                     ->firstOrFail();
        
        $attendances = Attendance::where('student_id', $studentId)
                               ->latest()
                               ->paginate(10);
                               
        return view('instructor.attendances.show', [
            'student' => $student,
            'attendances' => $attendances
        ]);
    }
}