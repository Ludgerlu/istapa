<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('sort_order')->paginate(15);
        return view($this->getRoutePrefix() . '.programs.index', compact('programs'));
    }

    public function create()
    {
        return view($this->getRoutePrefix() . '.programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'short_description_en' => 'nullable|string',
            'short_description_fr' => 'nullable|string',
            'content_en' => 'required|string',
            'content_fr' => 'required|string',
            'duration_months' => 'nullable|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Generate slug from English title (fallback to French)
        $slug = Str::slug($validated['title_en']) ?: Str::slug($validated['title_fr']);

        // Handle cover image upload
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('programs', 'public');
        }

        $program = Program::create([
            'slug' => $slug,
            'cover_image' => $coverPath,
            'duration_months' => $validated['duration_months'] ?? null,
            'title_en' => $validated['title_en'],
            'title_fr' => $validated['title_fr'],
            'short_description_en' => $validated['short_description_en'],
            'short_description_fr' => $validated['short_description_fr'],
            'content_en' => $validated['content_en'],
            'content_fr' => $validated['content_fr'],
            'is_published' => $request->has('is_published'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Programme créé avec succès.',
                'redirect' => route($this->getRoutePrefix() . '.programs.show', $program)
            ]);
        }

        return redirect()->route($this->getRoutePrefix() . '.programs.show', $program)
                         ->with('success', 'Programme créé avec succès.');
    }

    public function show(Program $program)
    {
        return view($this->getRoutePrefix() . '.programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        return view($this->getRoutePrefix() . '.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'short_description_en' => 'nullable|string',
            'short_description_fr' => 'nullable|string',
            'content_en' => 'required|string',
            'content_fr' => 'required|string',
            'duration_months' => 'nullable|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer',
            'remove_cover' => 'nullable|boolean',
        ]);

        // Update slug if title changed
        if ($program->title_en !== $validated['title_en']) {
            $slug = Str::slug($validated['title_en']) ?: Str::slug($validated['title_fr']);
            $program->slug = $slug;
        }

        // Handle cover image removal
        if ($request->has('remove_cover') && $request->remove_cover == 1) {
            if ($program->cover_image) {
                Storage::disk('public')->delete($program->cover_image);
                $program->cover_image = null;
            }
        }

        // Handle new cover image
        if ($request->hasFile('cover_image')) {
            // Delete old if exists
            if ($program->cover_image) {
                Storage::disk('public')->delete($program->cover_image);
            }
            $program->cover_image = $request->file('cover_image')->store('programs', 'public');
        }

        $program->fill([
            'duration_months' => $validated['duration_months'] ?? null,
            'title_en' => $validated['title_en'],
            'title_fr' => $validated['title_fr'],
            'short_description_en' => $validated['short_description_en'],
            'short_description_fr' => $validated['short_description_fr'],
            'content_en' => $validated['content_en'],
            'content_fr' => $validated['content_fr'],
            'is_published' => $request->has('is_published'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ])->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Programme mis à jour.',
                'redirect' => route($this->getRoutePrefix() . '.programs.show', $program)
            ]);
        }

        return redirect()->route($this->getRoutePrefix() . '.programs.show', $program)
                         ->with('success', 'Programme mis à jour.');
    }

    public function destroy(Program $program)
    {
        if ($program->cover_image) {
            Storage::disk('public')->delete($program->cover_image);
        }
        $program->delete();

        return redirect()->route($this->getRoutePrefix() . '.programs.index')
                         ->with('success', 'Programme supprimé.');
    }

    protected function getRoutePrefix()
    {
        return auth()->user()->role === 'manager' ? 'manager' : 'admin';
    }
}
