<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\User;
use App\Models\Event;


class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = BlogPost::with('author')
            ->when($request->q,      fn($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15);

        return view($this->getRoutePrefix() . '.blog.index', compact('blogs'));
    }

    /**
     * Show form to create a new blog post
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view($this->getRoutePrefix() . '.blog.create', compact('categories'));
    }

    /**
     * Store a newly created blog post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'title_en'         => 'required|string|max:255',
            'title_fr'         => 'required|string|max:255',
            'excerpt_en'       => 'nullable|string',
            'excerpt_fr'       => 'nullable|string',
            'content_en'       => 'required|string',
            'content_fr'       => 'required|string',
            'meta_description_en' => 'nullable|string',
            'meta_description_fr' => 'nullable|string',
            'cover_image'      => 'nullable|image|max:2048',
            'status'           => 'required|in:draft,published,archived',
            'published_at'     => 'nullable|date',
        ]);

        $validated['author_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title_en'] . '-' . uniqid());

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('blog_covers', 'public');
            $validated['cover_image'] = $path;
        }

        BlogPost::create($validated);

        return redirect()->route($this->getRoutePrefix() . '.blogs.index')
                         ->with('success', 'Article créé avec succès.');
    }

    /**
     * Display a single blog post with its comments (for admin)
     */
    public function show(BlogPost $blog)
    {
        // Load comments with user and replies (nested)
        $comments = $blog->comments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id')   // only top-level comments
            ->latest()
            ->get();

        return view($this->getRoutePrefix() . '.blog.show', compact('blog', 'comments'));
    }

    public function edit(BlogPost $blog)
    {
        $categories = BlogCategory::all();
        return view($this->getRoutePrefix() . '.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $data = $request->validate([
            'blog_category_id'     => 'nullable|exists:blog_categories,id',
            'status'               => 'required|in:draft,published,archived',
            'published_at'         => 'nullable|date',
            'title_en'             => 'required|string|max:255',
            'title_fr'             => 'required|string|max:255',
            'excerpt_en'           => 'nullable|string',
            'excerpt_fr'           => 'nullable|string',
            'content_en'           => 'required|string',
            'content_fr'           => 'required|string',
            'meta_description_en'  => 'nullable|string',
            'meta_description_fr'  => 'nullable|string',
            'cover_image'          => 'nullable|image|max:2048',
            'remove_cover'         => 'nullable|boolean',
        ]);

        // Handle cover image removal / upload
        if ($request->boolean('remove_cover') && $blog->cover_image) {
            \Storage::disk('public')->delete($blog->cover_image);
            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($blog->cover_image) {
                \Storage::disk('public')->delete($blog->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('blog_covers', 'public');
        }
        
        $blog->update($data);

        return redirect()->route($this->getRoutePrefix() . '.blogs.index')
                        ->with('success', 'Article mis à jour.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->cover_image) {
            \Storage::disk('public')->delete($blog->cover_image);
        }
        $blog->delete();

        return redirect()->route($this->getRoutePrefix() . '.blogs.index')->with('success', 'Article supprimé.');
    }

    // ----- Comment approval methods (used in Show view) -----

    /**
     * Approve a comment
     */
    public function approveComment(BlogComment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Commentaire approuvé.');
    }

    /**
     * Unapprove (disapprove) a comment
     */
    public function disapproveComment(BlogComment $comment)
    {
        $comment->update(['is_approved' => false]);
        return back()->with('success', 'Commentaire désapprouvé.');
    }

    /**
     * Delete a comment
     */
    public function destroyComment(BlogComment $comment)
    {
        // Also delete its replies
        $comment->replies()->delete();
        $comment->delete();
        return back()->with('success', 'Commentaire supprimé.');
    }

    protected function getRoutePrefix()
    {
        return auth()->user()->role === 'manager' ? 'manager' : 'admin';
    }
}
