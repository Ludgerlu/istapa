<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('creator');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                  ->orWhere('title_fr', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        $events = $query->latest('created_at')->paginate(15);
        return view('gestionnaire.events.index', compact('events'));
    }

    public function create()
    {
        return view('gestionnaire.events.create');
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
            'cover_image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
            'location' => 'nullable|string',
            'start_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'end_time' => 'nullable|date_format:H:i',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title_en'] . '-' . uniqid());
        $validated['created_by'] = Auth::id();

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('event_covers', 'public');
            $validated['cover_image'] = $path;
        }

        $event = Event::create($validated);

        return redirect()->route('gestionnaire.events.show', $event)
                         ->with('success', 'Événement créé avec succès.');
    }

    public function show(Event $event)
    {
        $event->load('images', 'creator');
        return view('gestionnaire.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('gestionnaire.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'short_description_en' => 'nullable|string',
            'short_description_fr' => 'nullable|string',
            'content_en' => 'required|string',
            'content_fr' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
            'location' => 'nullable|string',
            'start_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'end_time' => 'nullable|date_format:H:i',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image) {
                Storage::disk('public')->delete($event->cover_image);
            }
            $path = $request->file('cover_image')->store('event_covers', 'public');
            $validated['cover_image'] = $path;
        }

        $event->update($validated);

        return redirect()->route('gestionnaire.events.show', $event)
                         ->with('success', 'Événement mis à jour avec succès.');
    }

    public function destroy(Event $event)
    {
        if ($event->cover_image) {
            Storage::disk('public')->delete($event->cover_image);
        }

        $event->images()->each(function ($image) {
            Storage::disk('public')->delete($image->image_path);
        });

        $event->delete();

        return redirect()->route('gestionnaire.events.index')
                         ->with('success', 'Événement supprimé avec succès.');
    }

    public function storeImage(Request $request, Event $event)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('event_images', 'public');
        $event->images()->create(['image_path' => $path]);

        return back()->with('success', 'Image ajoutée avec succès.');
    }

    public function destroyImage(EventImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image supprimée avec succès.');
    }

    public function reorderImages(Request $request)
    {
        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'integer|exists:event_images,id',
        ]);

        foreach ($validated['images'] as $index => $imageId) {
            EventImage::where('id', $imageId)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
