<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GalleryImageController extends Controller
{
    /**
     * Display a listing of albums.
     */
    public function index()
    {
        $albums = GalleryAlbum::orderBy('created_at', 'desc')->paginate(12);
        return view($this->getRoutePrefix() . '.gallery.index', compact('albums'));
    }

    /**
     * Show form to create a new album.
     */
    public function create()
    {
        return view($this->getRoutePrefix() . '.gallery.create');
    }

    /**
     * Store a newly created album.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['title_fr'] . '-' . uniqid());
        $validated['created_at'] = now();
        $validated['sort_order'] = 0;

        $album = GalleryAlbum::create($validated);

        return redirect()->route($this->getRoutePrefix() . '.gallery.edit', $album->id)
                         ->with('success', 'Album créé avec succès. Vous pouvez maintenant ajouter des photos.');
    }


    /**
     * Display a single album publicly (front office), with its images.
     * Looks up by slug so public URLs don't leak database IDs.
     */
    public function show($id)
    {
        $album = GalleryAlbum::with('images')->findOrFail($id);

        return view($this->getRoutePrefix() . '.gallery.show', compact('album'));
    }

    /**
     * Show form to edit an album with its images.
     */
    public function edit($id)
    {
        $album = GalleryAlbum::with('images')->findOrFail($id);
        return view($this->getRoutePrefix() . '.gallery.edit', compact('album'));
    }

    /**
     * Update the specified album.
     */
    public function update(Request $request, $id)
    {
        $album = GalleryAlbum::findOrFail($id);

        $validated = $request->validate([
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_fr' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $album->update($validated);

        return redirect()->route($this->getRoutePrefix() . '.gallery.show', $album->id)
                         ->with('success', 'Album mis à jour avec succès.');
    }

    /**
     * Remove the specified album and all its images.
     */
    public function destroy($id)
    {
        $album = GalleryAlbum::findOrFail($id);

        // Delete all images and their files
        foreach ($album->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            Storage::disk('public')->delete($this->getThumbnailPath($image->image_path));
            $image->delete();
        }

        // Delete cover image if exists
        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
        }

        $album->delete();

        return redirect()->route($this->getRoutePrefix() . '.gallery.index')
                         ->with('success', 'Album supprimé avec succès.');
    }

    /**
     * Upload images to an album.
     */
    public function upload(Request $request, $id)
    {
        $album = GalleryAlbum::findOrFail($id);

        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $uploaded = [];
        $maxOrder = $album->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $index => $image) {
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = uniqid() . '_' . time() . '_' . $index . '.' . $image->getClientOriginalExtension();
            
            // Store original image
            $path = 'gallery_images/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($image));
            
            // Create and store thumbnail
            // $thumbnailPath = 'gallery_thumbnails/' . $filename;
            // $this->createThumbnail($image, $thumbnailPath);
            
            // Save to database
            $album->images()->create([
                'image_path' => $path,
                'caption' => $originalName,
                'sort_order' => $maxOrder + $index + 1,
                'uploaded_by' => Auth::id(),
                'created_at' => now(),
            ]);
            
            $uploaded[] = $filename;
        }

        // If no cover image yet, set the first uploaded image as cover
        if (!$album->cover_image && !empty($uploaded)) {
            $firstImage = $album->images()->latest()->first();
            if ($firstImage) {
                $album->update(['cover_image' => $firstImage->image_path]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($uploaded) . ' photo(s) ajoutée(s) avec succès.',
            'files' => $uploaded
        ]);
    }

    /**
     * Delete a single image from an album.
     */
    public function deleteImage($id)
    {
        $image = GalleryImage::findOrFail($id);
        $album = $image->album;

        // Delete files
        Storage::disk('public')->delete($image->image_path);
        Storage::disk('public')->delete($this->getThumbnailPath($image->image_path));

        // If this image was the cover, remove cover
        if ($album->cover_image === $image->image_path) {
            $album->update(['cover_image' => null]);
            
            // Optionally set another image as cover
            $newCover = $album->images()->where('id', '!=', $id)->first();
            if ($newCover) {
                $album->update(['cover_image' => $newCover->image_path]);
            }
        }

        $image->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Set an image as the album cover.
     */
    public function setCover($albumId, $imageId)
    {
        $album = GalleryAlbum::findOrFail($albumId);
        $image = GalleryImage::findOrFail($imageId);

        $album->update(['cover_image' => $image->image_path]);

        return response()->json(['success' => true]);
    }

    /**
     * Reorder images in an album.
     */
    public function reorder(Request $request, $albumId)
    {
        $album = GalleryAlbum::findOrFail($albumId);
        
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:gallery_images,id'
        ]);

        foreach ($request->order as $index => $imageId) {
            GalleryImage::where('id', $imageId)
                        ->where('album_id', $albumId)
                        ->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Create a thumbnail for an image.
     */
    private function createThumbnail($image, $thumbnailPath)
    {
        $img = Image::make($image);
        $img->fit(300, 300, function ($constraint) {
            $constraint->upsize();
        });
        Storage::disk('public')->put($thumbnailPath, (string) $img->encode());
    }

    /**
     * Get thumbnail path from original image path.
     */
    private function getThumbnailPath($imagePath)
    {
        return str_replace('gallery_images/', 'gallery_thumbnails/', $imagePath);
    }

    /**
     * Get album cover URL.
     */
    public function getCoverUrl($imagePath)
    {
        return $imagePath ? asset('storage/' . $imagePath) : null;
    }

    protected function getRoutePrefix()
    {
        return auth()->user()->role === 'manager' ? 'manager' : 'admin';
    }
}