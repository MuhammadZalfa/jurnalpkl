<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function index()
    {
        $today = Carbon::now('Asia/Jakarta')->toDateString();
        
        $todayAttendance = Attendance::where('student_id', Auth::id())
            ->where('date', $today)
            ->first();

        $attendances = Attendance::where('student_id', Auth::id())
            ->orderBy('date', 'desc')
            ->take(7)
            ->get();

        return view('siswa.absensi', [
            'todayAttendance' => $todayAttendance,
            'attendances' => $attendances
        ]);
    }

    public function store(Request $request)
    {
        $today = Carbon::now('Asia/Jakarta')->toDateString();
        $now = Carbon::now('Asia/Jakarta');
        $todayAttendance = Attendance::where('student_id', Auth::id())
            ->where('date', $today)
            ->first();

        // Check-out process
        if ($todayAttendance) {
            if ($todayAttendance->type === 'masuk' && !$todayAttendance->time_out) {
                try {
                    $timeOut = $now->toTimeString();
                    $timeIn = Carbon::parse($todayAttendance->date . ' ' . $todayAttendance->time_in);
                    $duration = $now->diffInMinutes($timeIn);

                    $todayAttendance->update([
                        'time_out' => $timeOut,
                        'duration' => $duration
                    ]);

                    return redirect()->route('siswa.absensi')
                        ->with('success', 'Absensi pulang berhasil disimpan! Durasi: ' . $todayAttendance->duration_formatted);
                } catch (\Exception $e) {
                    Log::error('Check-out error: ' . $e->getMessage());
                    return redirect()->back()
                        ->with('error', 'Gagal menyimpan absen pulang: ' . $e->getMessage());
                }
            }
            return redirect()->back()
                ->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        // Check-in process
        $validator = Validator::make($request->all(), [
            'attendance_type' => 'required|in:masuk,sakit,izin',
            'reason' => 'nullable|min:10|max:500'
        ], [
            'attendance_type.required' => 'Silakan pilih jenis absensi',
            'reason.min' => 'Alasan minimal 10 karakter (jika diisi)'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form!');
        }

        try {
            $data = [
                'student_id' => Auth::id(),
                'date' => $today,
                'type' => $request->attendance_type,
                'notes' => $request->notes,
            ];

            if ($request->filled('reason')) {
                $data['reason'] = $request->reason;
            }

            if ($request->attendance_type === 'masuk') {
                $data['time_in'] = $now->toTimeString();
            }

            Attendance::create($data);

            return redirect()->route('siswa.absensi')
                ->with('success', 'Absensi masuk berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Attendance error: '.$e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: '.$e->getMessage())
                ->withInput();
        }
    }
}