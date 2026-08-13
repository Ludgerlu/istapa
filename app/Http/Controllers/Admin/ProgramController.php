<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramImage;
use App\Models\Certificate;
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
        // Add validation for new fields
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
            // New fields
            'degree_code' => 'nullable|string|max:30',
            'degree_name_en' => 'nullable|string|max:120',
            'degree_name_fr' => 'nullable|string|max:120',
            'degree_description_en' => 'nullable|string',
            'degree_description_fr' => 'nullable|string',
            'certificates' => 'nullable|array', // array of certificate IDs
        ]);

        $slug = Str::slug($validated['title_en']) ?: Str::slug($validated['title_fr']);

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
            'degree_code' => $validated['degree_code'] ?? null,
            'degree_name_en' => $validated['degree_name_en'] ?? null,
            'degree_name_fr' => $validated['degree_name_fr'] ?? null,
            'degree_description_en' => $validated['degree_description_en'] ?? null,
            'degree_description_fr' => $validated['degree_description_fr'] ?? null,
        ]);

        // Attach certificates
        if (!empty($validated['certificates'])) {
            $program->certificates()->sync($validated['certificates']);
        }

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
            // New fields
            'degree_code' => 'nullable|string|max:30',
            'degree_name_en' => 'nullable|string|max:120',
            'degree_name_fr' => 'nullable|string|max:120',
            'degree_description_en' => 'nullable|string',
            'degree_description_fr' => 'nullable|string',
            'certificates' => 'nullable|array',
        ]);

        if ($program->title_en !== $validated['title_en']) {
            $program->slug = Str::slug($validated['title_en']) ?: Str::slug($validated['title_fr']);
        }

        // Handle cover image removal/update
        if ($request->has('remove_cover') && $request->remove_cover == 1) {
            if ($program->cover_image) {
                Storage::disk('public')->delete($program->cover_image);
                $program->cover_image = null;
            }
        }

        if ($request->hasFile('cover_image')) {
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
            'degree_code' => $validated['degree_code'] ?? null,
            'degree_name_en' => $validated['degree_name_en'] ?? null,
            'degree_name_fr' => $validated['degree_name_fr'] ?? null,
            'degree_description_en' => $validated['degree_description_en'] ?? null,
            'degree_description_fr' => $validated['degree_description_fr'] ?? null,
        ])->save();

        // Sync certificates
        if ($request->has('certificates')) {
            $program->certificates()->sync($validated['certificates']);
        } else {
            $program->certificates()->detach();
        }

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

    // ----- Gallery management methods -----

    public function storeImage(Request $request, Program $program)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'alt_en' => 'nullable|string|max:150',
            'alt_fr' => 'nullable|string|max:150',
            'is_cover' => 'nullable|boolean',
        ]);

        // If this image is marked as cover, unset other cover images
        if ($request->boolean('is_cover')) {
            $program->images()->update(['is_cover' => false]);
        }

        $path = $request->file('image')->store('programs/gallery', 'public');

        $image = $program->images()->create([
            'image_path' => $path,
            'alt_en' => $request->alt_en,
            'alt_fr' => $request->alt_fr,
            'is_cover' => $request->boolean('is_cover'),
            'sort_order' => $program->images()->max('sort_order') + 1,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Image ajoutée.', 'image' => $image]);
        }

        return back()->with('success', 'Image ajoutée.');
    }

    public function destroyImage(ProgramImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image supprimée.');
    }

    public function reorderImages(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:program_images,id',
        ]);

        foreach ($request->order as $index => $id) {
            ProgramImage::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
