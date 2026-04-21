<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassModel as SchoolClass;
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
            'total_students'      => User::students()->count(),
            'total_teachers'      => User::teachers()->count(),
            'total_classes'       => SchoolClass::count(),
            'total_fees_collected'=> FeesPayment::sum('fees_paid_amount'),
            'pending_fees'        => FeesPayment::selectRaw('SUM(total_amount - fees_paid_amount) as pending')
                                        ->value('pending') ?? 0,
            'upcoming_events'     => Event::upcoming()->count(),
        ];

        // Chart data — students registered per month (current year)
        $currentYear  = now()->year;
        $monthlyStudents = User::students()
            ->selectRaw('MONTH(registered) as month, COUNT(*) as total')
            ->whereYear('registered', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyFees = FeesPayment::selectRaw('MONTH(created_date) as month, SUM(fees_paid_amount) as total')
            ->whereYear('created_date', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartData = [
            'students' => collect(range(1, 12))->map(fn($m) => $monthlyStudents[$m] ?? 0)->values()->all(),
            'fees'     => collect(range(1, 12))->map(fn($m) => round(($monthlyFees[$m] ?? 0) / 1000))->values()->all(),
        ];

        // Tables
        $recentStudents  = User::students()->with('userMeta')->latest('registered')->take(7)->get();
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
