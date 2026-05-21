<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of academic years.
     */
    public function index()
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->paginate(15);
        return view('admin.academic-years.index', compact('academicYears'));
    }

    /**
     * Show the form for creating a new academic year.
     */
    public function create()
    {
        return view('admin.academic-years.create');
    }

    /**
     * Store a newly created academic year in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255|unique:academic_years,label',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        DB::transaction(function () use ($validated) {
            // If setting as current, unset any existing current year
            if (!empty($validated['is_current'])) {
                AcademicYear::where('is_current', true)->update(['is_current' => false]);
            }

            AcademicYear::create($validated);
        });

        return redirect()->route('admin.academic-years.index')
                         ->with('success', 'Année académique créée avec succès.');
    }

    /**
     * Display the specified academic year.
     */
    public function show(AcademicYear $academicYear)
    {
        // Load optional relationships (classes, fees, exams count)
        $academicYear->loadCount(['classes', 'fees', 'exams']);
        return view('admin.academic-years.show', compact('academicYear'));
    }

    /**
     * Show the form for editing the specified academic year.
     */
    public function edit(AcademicYear $academicYear)
    {
        return view('admin.academic-years.edit', compact('academicYear'));
    }

    /**
     * Update the specified academic year in storage.
     */
    public function update(Request $request, AcademicYear $academicYear)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255|unique:academic_years,label,' . $academicYear->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        DB::transaction(function () use ($validated, $academicYear) {
            // If setting as current and it's not already the current one
            if (!empty($validated['is_current']) && !$academicYear->is_current) {
                AcademicYear::where('is_current', true)->update(['is_current' => false]);
            }
            // If unsetting current (explicit false) and it was current, don't touch others
            // But if user sets is_current = false and it's the current year, just update it.
            
            $academicYear->update($validated);
        });

        return redirect()->route('admin.academic-years.index')
                         ->with('success', 'Année académique mise à jour.');
    }

    /**
     * Remove the specified academic year from storage.
     */
    public function destroy(AcademicYear $academicYear)
    {
        // Check if it has related data (classes, fees, exams)
        if ($academicYear->classes()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des classes sont liées à cette année.');
        }
        if ($academicYear->fees()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des frais sont liés à cette année.');
        }
        if ($academicYear->exams()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer : des examens sont liés à cette année.');
        }

        $academicYear->delete();
        return redirect()->route('admin.academic-years.index')
                         ->with('success', 'Année académique supprimée.');
    }
}