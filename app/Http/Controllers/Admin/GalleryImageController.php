<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    public function store(Request $request, GalleryAlbum $album)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('gallery_images', 'public');
        $maxOrder = $album->images()->max('sort_order') ?? 0;

        $album->images()->create([
            'image_path' => $path,
            'caption' => $request->caption,
            'sort_order' => $maxOrder + 1,
            'uploaded_by' => Auth::id(),
            'created_at' => now(),
        ]);

        return back()->with('success', 'Image ajoutée à la galerie.');
    }

    public function destroy(GalleryImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Image supprimée.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:gallery_images,id',
        ]);

        foreach ($request->order as $index => $id) {
            GalleryImage::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}