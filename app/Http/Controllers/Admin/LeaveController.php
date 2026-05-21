<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with(['student.user', 'reviewer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')");
        }

        if ($request->filled('student_name')) {
            $search = $request->student_name;
            $query->whereHas('student.user', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $leaves = $query->paginate(20);

        return view('admin.leaves.index', compact('leaves'));
    }

    public function show(Leave $leave)
    {
        $leave->load(['student.user', 'reviewer']);
        return view('admin.leaves.show', compact('leave'));
    }

    public function approve(Request $request, Leave $leave)
    {
        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $leave->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'review_comment' => $request->comment,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Demande de congé approuvée.');
    }

    public function reject(Request $request, Leave $leave)
    {
        if ($leave->status !== 'pending') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $leave->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'review_comment' => $request->comment,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Demande de congé refusée.');
    }

    public function destroy(Leave $leave)
    {
        // Delete attachment file if exists
        if ($leave->attachment && \Storage::disk('public')->exists($leave->attachment)) {
            \Storage::disk('public')->delete($leave->attachment);
        }
        $leave->delete();
        return redirect()->route('admin.leaves.index')
                         ->with('success', 'Demande supprimée.');
    }
}