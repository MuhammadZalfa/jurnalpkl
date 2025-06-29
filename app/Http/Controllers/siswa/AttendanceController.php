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
                    $timeOut = $now->format('H:i:s');
                    
                    // PERBAIKAN: Parse tanggal dan waktu dengan benar
                    // Gunakan toDateString() untuk mendapatkan format Y-m-d saja
                    $dateString = Carbon::parse($todayAttendance->date)->toDateString();
                    $timeIn = Carbon::parse($dateString . ' ' . $todayAttendance->time_in, 'Asia/Jakarta');
                    $timeOutObj = Carbon::parse($dateString . ' ' . $timeOut, 'Asia/Jakarta');

                    // Handle kasus melewati tengah malam
                    if ($timeOutObj->lessThan($timeIn)) {
                        $timeOutObj->addDay();
                    }

                    $duration = $timeIn->diffInMinutes($timeOutObj);

                    // Handle durasi kurang dari 1 menit
                    if ($duration < 1 && $timeOutObj->diffInSeconds($timeIn) > 0) {
                        $duration = 0;
                    }

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
                $data['time_in'] = $now->format('H:i:s');
            }

            Attendance::create($data);

            return redirect()->route('siswa.absensi')
                ->with('success', 'Absensi berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Attendance error: '.$e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: '.$e->getMessage())
                ->withInput();
        }
    }
}