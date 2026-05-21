<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdmissionRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = AdmissionRequest::with(['program', 'reviewer']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: show pending first, then others
            $query->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')");
        }

        // Search by name, email, reference
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('reference_code', 'like', "%{$search}%");
            });
        }

        $admissions = $query->paginate(20);

        return view('admin.admissions.index', compact('admissions'));
    }

    public function show(AdmissionRequest $admission)
    {
        $admission->load(['program', 'reviewer', 'documents']);
        return view('admin.admissions.show', compact('admission'));
    }

    public function approve(AdmissionRequest $admission)
    {
        if ($admission->status !== 'pending') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $admission->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'status_comment' => request('comment') ?? null,
        ]);

        // Optional: automatically create a user account (student) here
        // $this->createUserFromAdmission($admission);

        return back()->with('success', 'Demande d\'admission approuvée.');
    }

    public function reject(Request $request, AdmissionRequest $admission)
    {
        if ($admission->status !== 'pending') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $request->validate([
            'comment' => 'nullable|string|max:500',
        ]);

        $admission->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'status_comment' => $request->comment,
        ]);

        return back()->with('success', 'Demande d\'admission refusée.');
    }

    public function destroy(AdmissionRequest $admission)
    {
        // Delete associated documents first (optional)
        foreach ($admission->documents as $doc) {
            if ($doc->file_path && \Storage::disk('public')->exists($doc->file_path)) {
                \Storage::disk('public')->delete($doc->file_path);
            }
            $doc->delete();
        }
        $admission->delete();
        return redirect()->route('admin.admissions.index')
                         ->with('success', 'Demande supprimée.');
    }
}