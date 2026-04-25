<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel as SchoolClass;
use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Classes;
use App\Models\FeesPayment;
use App\Models\Event;
use App\Models\Leave;
use App\Models\Message;
use App\Models\Subject;
use App\Models\Teacher;


class DashboardController extends Controller
{
    // ─── Admin Dashboard ────────────────────────────────────────────────────────

    public function dashboard()
    {
        // KPI stats
        $stats = [
            'total_students'      => User::where('role', 'student')->count() ?? 0,
            'total_teachers'      => User::where('role', 'teacher')->count() ?? 0,
            'total_classes'       => Classes::count(),
            'total_fees_collected'=> FeesPayment::sum('amount_paid') ?? 0,
            'pending_fees'        => 0,
            'upcoming_events'     => Event::upcoming()->count(),
        ];

        // Chart data — students registered per month (current year)
        $currentYear  = now()->year;
        $monthlyStudents = User::where('role', 'student')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyFees = FeesPayment::selectRaw('MONTH(created_at) as month, SUM(amount_paid) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartData = [
            'students' => collect(range(1, 12))->map(fn($m) => $monthlyStudents[$m] ?? 0)->values()->all(),
            'fees'     => collect(range(1, 12))->map(fn($m) => round(($monthlyFees[$m] ?? 0) / 1000))->values()->all(),
        ];

        // Tables
        $recentStudents  = User::where('role', 'student')->latest('created_at')->take(7)->get();
        $upcomingEvents  = Event::upcoming()->take(7)->get();
        $pendingLeaves   = Leave::with('student')->where('status', 'pending')->latest()->take(6)->get();
        // $recentMessages  = Message::with('sender')->latest('send_date')->take(6)->get();

        return view('admin.dashboard', compact(
            'stats', 'chartData', 'recentStudents', 'upcomingEvents', 'pendingLeaves', /* 'recentMessages' */
        ));
    }

    public function profile()
    {
        return view('admin.profile', ['user' => auth()->user()]);
    }
}
