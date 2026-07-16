<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        return view($this->getRoutePrefix() . '.events.index', compact('events'));
    }

    public function create()
    {
        return view($this->getRoutePrefix() . '.events.create');
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

        return redirect()->route($this->getRoutePrefix() . '.events.show', $event)
                     ->with('success', 'Événement créé avec succès.');
    }

    public function show(Event $event)
    {
        $event->load('images', 'creator');
        return view($this->getRoutePrefix() . '.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view($this->getRoutePrefix() . '.events.edit', compact('event'));
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

        if ($request->has('remove_cover') && $request->remove_cover) {
            if ($event->cover_image) {
                Storage::disk('public')->delete($event->cover_image);
                $event->cover_image = null;
            }
        }

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image) {
                Storage::disk('public')->delete($event->cover_image);
            }
            $path = $request->file('cover_image')->store('event_covers', 'public');
            $validated['cover_image'] = $path;
        }

        $event->update($validated);

        return redirect()->route($this->getRoutePrefix() . '.events.show', $event)
                         ->with('success', 'Événement mis à jour.');
    }

    public function destroy(Event $event)
    {
        if ($event->cover_image) {
            Storage::disk('public')->delete($event->cover_image);
        }
        foreach ($event->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        $event->delete();

        return redirect()->route($this->getRoutePrefix() . '.events.index')
                         ->with('success', 'Événement supprimé.');
    }

    // Image management methods
    public function storeImage(Request $request, Event $event)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('event_galleries', 'public');
        $maxOrder = $event->images()->max('sort_order') ?? 0;

        $event->images()->create([
            'image_path' => $path,
            'caption' => $request->caption,
            'sort_order' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Image ajoutée à la galerie.');
    }

    public function destroyImage(EventImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Image supprimée.');
    }

    public function reorderImages(Request $request)
    {
        foreach ($request->order as $index => $id) {
            EventImage::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    protected function getRoutePrefix()
    {
        return auth()->user()->role === 'manager' ? 'manager' : 'admin';
    }
}
