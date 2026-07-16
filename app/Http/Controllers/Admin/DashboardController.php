<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classes;
use App\Models\FeesPayment;
use App\Models\Event;
use App\Models\Leave;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Get the route prefix based on the authenticated user's role.
     */
    protected function getRoutePrefix()
    {
        return auth()->user()->role === 'manager' ? 'manager' : 'admin';
    }

    /**
     * Admin/Manager dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // ─── Admin Dashboard ──────────────────────────────────────────────
        if ($user->role === 'admin') {
            // KPI stats (school oriented)
            $stats = [
                'total_students'      => User::where('role', 'student')->count(),
                'total_teachers'      => User::where('role', 'teacher')->count(),
                'total_classes'       => Classes::count(),
                'total_fees_collected'=> FeesPayment::sum('amount_paid') ?? 0,
                'pending_fees'        => 0, // you can implement logic later
                'upcoming_events'     => Event::upcoming()->count(),
            ];

            // Chart data — students & fees per month
            $currentYear = now()->year;
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

            // Recent records
            $recentStudents  = User::where('role', 'student')->latest('created_at')->take(7)->get();
            $upcomingEvents  = Event::upcoming()->take(7)->get();
            $pendingLeaves   = Leave::with('student')->where('status', 'pending')->latest()->take(6)->get();

            return view($this->getRoutePrefix() . '.dashboard', compact(
                'stats', 'chartData', 'recentStudents', 'upcomingEvents', 'pendingLeaves'
            ));
        }

        // ─── Manager Dashboard ────────────────────────────────────────────
        // Blog stats
        $totalBlogs = BlogPost::where('status', 'published')->count();
        $totalEvents = Event::where('is_published', true)->count();

        // Latest 5 blogs and events
        $latestBlogs = BlogPost::with('author')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $latestEvents = Event::with('creator')
            ->where('is_published', true)
            ->latest('start_date')
            ->take(5)
            ->get();

        // Chart: monthly views for blogs and events (current year)
        $currentYear = now()->year;
        $monthlyBlogViews = BlogPost::selectRaw('MONTH(created_at) as month, SUM(view_count) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyEventViews = Event::selectRaw('MONTH(created_at) as month, SUM(view_count) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartData = [
            'blogs'  => collect(range(1, 12))->map(fn($m) => $monthlyBlogViews[$m] ?? 0)->values()->all(),
            'events' => collect(range(1, 12))->map(fn($m) => $monthlyEventViews[$m] ?? 0)->values()->all(),
        ];

        return view($this->getRoutePrefix() . '.dashboard', compact(
            'totalBlogs', 'totalEvents', 'latestBlogs', 'latestEvents', 'chartData'
        ));
    }

    /**
     * Profile page (shared for both roles)
     */
    public function profile()
    {
        return view($this->getRoutePrefix() . '.profile', ['user' => auth()->user()]);
    }
}