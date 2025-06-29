<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journal;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        // Get supervised student IDs
        $studentIds = $this->getSupervisedStudentIds();
        
        // Get statistics for all supervised students
        $stats = [
            'totalStudents' => count($studentIds),
            'totalDays' => $this->getTotalDays($studentIds),
            'daysWithBoth' => $this->getDaysWithBoth($studentIds),
            'daysMissingJournal' => $this->getDaysMissingJournal($studentIds),
            'daysMissingAttendance' => $this->getDaysMissingAttendance($studentIds),
            'verifiedJournals' => $this->getVerifiedJournals($studentIds),
            'pendingJournals' => $this->getPendingJournals($studentIds),
            'recentActivities' => $this->getRecentActivities($studentIds),
            'students' => $this->getStudentStats($studentIds)
        ];

        return view('admin.statistik-guru', $stats);
    }

    protected function getSupervisedStudentIds()
    {
        $currentUser = Auth::user();
        return User::where('role', 'student')
                ->where('pembimbing', $currentUser->pembimbing)
                ->pluck('id');
    }

    protected function getTotalDays($studentIds)
    {
        $firstJournal = Journal::whereIn('user_id', $studentIds)
                             ->orderBy('date', 'asc')
                             ->first();
        
        if (!$firstJournal) return 0;
        
        $startDate = $firstJournal->date;
        $endDate = now();
        
        return $startDate->diffInWeekdays($endDate) + 1;
    }

    protected function getDaysWithBoth($studentIds)
    {
        return DB::table('journals')
                ->whereIn('user_id', $studentIds)
                ->whereExists(function($query) {
                    $query->select(DB::raw(1))
                          ->from('attendances')
                          ->whereRaw('attendances.student_id = journals.user_id')
                          ->whereRaw('DATE(attendances.date) = DATE(journals.date)');
                })
                ->count();
    }

    protected function getDaysMissingJournal($studentIds)
    {
        return DB::table('attendances')
                ->whereIn('student_id', $studentIds)
                ->whereNotExists(function($query) {
                    $query->select(DB::raw(1))
                          ->from('journals')
                          ->whereRaw('journals.user_id = attendances.student_id')
                          ->whereRaw('DATE(journals.date) = DATE(attendances.date)');
                })
                ->count();
    }

    protected function getDaysMissingAttendance($studentIds)
    {
        return DB::table('journals')
                ->whereIn('user_id', $studentIds)
                ->whereNotExists(function($query) {
                    $query->select(DB::raw(1))
                          ->from('attendances')
                          ->whereRaw('attendances.student_id = journals.user_id')
                          ->whereRaw('DATE(attendances.date) = DATE(journals.date)');
                })
                ->count();
    }

    protected function getVerifiedJournals($studentIds)
    {
        return Journal::whereIn('user_id', $studentIds)
                     ->where('status', 'approved')
                     ->count();
    }

    protected function getPendingJournals($studentIds)
    {
        return Journal::whereIn('user_id', $studentIds)
                     ->where('status', 'pending')
                     ->count();
    }

    protected function getRecentActivities($studentIds)
    {
        $journals = Journal::with(['user', 'user.attendances' => function($query) {
                            $query->select('id', 'student_id', 'date', 'time_in');
                        }])
                        ->whereIn('user_id', $studentIds)
                        ->orderBy('date', 'desc')
                        ->limit(5)
                        ->get();
        
        $activities = [];
        
        foreach ($journals as $journal) {
            $attendance = $journal->user->attendances->first(function($attendance) use ($journal) {
                return $attendance->date->format('Y-m-d') === $journal->date->format('Y-m-d');
            });
            
            $activities[] = [
                'type' => 'complete',
                'date' => $journal->date,
                'journal' => $journal,
                'attendance' => $attendance,
                'student' => $journal->user
            ];
        }
        
        return $activities;
    }

    protected function getStudentStats($studentIds)
    {
        $students = User::withCount([
                        'journals as verified_journals_count' => function($query) {
                            $query->where('status', 'approved');
                        },
                        'journals as pending_journals_count' => function($query) {
                            $query->where('status', 'pending');
                        },
                        'attendances',
                        'journals as total_journals_count'
                    ])
                    ->whereIn('id', $studentIds)
                    ->get();
        
        return $students->map(function($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'dudi' => $student->dudi,
                'total_journals' => $student->total_journals_count,
                'verified_journals' => $student->verified_journals_count,
                'pending_journals' => $student->pending_journals_count,
                'total_attendances' => $student->attendances_count,
                'completeness_percentage' => $student->attendances_count > 0 ? 
                    round(($student->verified_journals_count / $student->attendances_count) * 100) : 0
            ];
        });
    }
}