<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();
        $startDate = Carbon::now()->subMonths(3); // Ambil data 3 bulan terakhir
        $endDate = Carbon::now();

        // Data absensi
        $attendances = Attendance::where('student_id', $studentId)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        // Data jurnal
        $journals = Journal::where('user_id', $studentId)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        // Hitung statistik
        $totalDays = $attendances->count();
        $daysWithBoth = 0;
        $daysMissingJournal = [];
        $daysMissingAttendance = [];

        foreach ($attendances as $attendance) {
            $hasJournal = $journals->contains('date', $attendance->date);
            if ($hasJournal) {
                $daysWithBoth++;
            } else {
                $daysMissingJournal[] = $attendance;
            }
        }

        foreach ($journals as $journal) {
            $hasAttendance = $attendances->contains('date', $journal->date);
            if (!$hasAttendance) {
                $daysMissingAttendance[] = $journal;
            }
        }

        // Status jurnal
        $verifiedJournals = $journals->where('status', 'verified')->count();
        $pendingJournals = $journals->where('status', 'pending')->count();

        // Aktivitas terakhir
        $recentActivities = $this->getRecentActivities($attendances, $journals);

        return view('siswa.statistik', [
            'totalDays' => $totalDays,
            'daysWithBoth' => $daysWithBoth,
            'daysMissingJournal' => $daysMissingJournal,
            'daysMissingJournalCount' => count($daysMissingJournal),
            'daysMissingAttendance' => $daysMissingAttendance,
            'daysMissingAttendanceCount' => count($daysMissingAttendance),
            'verifiedJournals' => $verifiedJournals,
            'pendingJournals' => $pendingJournals,
            'recentActivities' => $recentActivities,
            'attendances' => $attendances,
            'journals' => $journals,
        ]);
    }

    private function getRecentActivities($attendances, $journals)
    {
        $activities = [];
        $combined = collect();

        // Gabungkan data absensi dan jurnal
        foreach ($attendances as $attendance) {
            $combined->push([
                'type' => 'attendance',
                'date' => $attendance->date,
                'data' => $attendance,
            ]);
        }

        foreach ($journals as $journal) {
            $combined->push([
                'type' => 'journal',
                'date' => $journal->date,
                'data' => $journal,
            ]);
        }

        // Urutkan berdasarkan tanggal terbaru
        $sorted = $combined->sortByDesc(function ($item) {
            return $item['date'];
        })->take(5);

        // Format aktivitas
        foreach ($sorted as $item) {
            if ($item['type'] === 'attendance') {
                $attendance = $item['data'];
                $journal = $journals->firstWhere('date', $attendance->date);

                $activities[] = [
                    'type' => $journal ? 'complete' : 'missing_journal',
                    'date' => $attendance->date,
                    'attendance' => $attendance,
                    'journal' => $journal,
                ];
            } else {
                $journal = $item['data'];
                $attendance = $attendances->firstWhere('date', $journal->date);

                if (!$attendance) {
                    $activities[] = [
                        'type' => 'missing_attendance',
                        'date' => $journal->date,
                        'attendance' => null,
                        'journal' => $journal,
                    ];
                }
            }
        }

        return array_slice($activities, 0, 3); // Ambil 3 teratas
    }

    public function chartData()
{
    $studentId = Auth::id();
    $startDate = Carbon::now()->subMonths(3);
    $endDate = Carbon::now();

    $attendances = Attendance::where('student_id', $studentId)
        ->whereBetween('date', [$startDate, $endDate])
        ->get();

    $journals = Journal::where('user_id', $studentId)
        ->whereBetween('date', [$startDate, $endDate])
        ->get();

    $complete = 0;
    $missingJournal = 0;
    $missingAttendance = 0;

    foreach ($attendances as $attendance) {
        $hasJournal = $journals->contains('date', $attendance->date);
        $complete += $hasJournal ? 1 : 0;
        $missingJournal += $hasJournal ? 0 : 1;
    }

    foreach ($journals as $journal) {
        $hasAttendance = $attendances->contains('date', $journal->date);
        $missingAttendance += $hasAttendance ? 0 : 1;
    }

    // Pastikan minimal ada 1 data untuk semua kategori
    if ($complete === 0 && $missingJournal === 0 && $missingAttendance === 0) {
        $complete = 1; // Default value jika tidak ada data
    }

    return response()->json([
        'complete' => $complete,
        'missing_journal' => $missingJournal,
        'missing_attendance' => $missingAttendance
    ]);
}
}