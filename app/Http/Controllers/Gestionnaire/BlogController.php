<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogComment;

class BlogController extends Controller
{
    public function dashboard()
    {
        $gestionnaire = Auth::user();
        $totalBlogs = BlogPost::count();
        $totalComments = BlogComment::count();
        
        return view('gestionnaire.dashboard', compact('gestionnaire', 'totalBlogs', 'totalComments'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('gestionnaire.profile', compact('user'));
    }

    public function index(Request $request)
    {
        $blogs = BlogPost::with('author')
            ->when($request->q,      fn($q, $s) => $q->where('title_en', 'like', "%{$s}%")->orWhere('title_fr', 'like', "%{$s}%"))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15);

        return view('gestionnaire.blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('gestionnaire.blog.create', compact('categories'));
    }

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

        return redirect()->route('gestionnaire.blogs.index')
                         ->with('success', 'Article créé avec succès.');
    }

    public function show(BlogPost $blog)
    {
        $comments = $blog->comments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return view('gestionnaire.blog.show', compact('blog', 'comments'));
    }

    public function edit(BlogPost $blog)
    {
        $categories = BlogCategory::all();
        return view('gestionnaire.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, BlogPost $blog)
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

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('blog_covers', 'public');
            $validated['cover_image'] = $path;
        }

        $blog->update($validated);

        return redirect()->route('gestionnaire.blogs.index')
                         ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return redirect()->route('gestionnaire.blogs.index')
                         ->with('success', 'Article supprimé avec succès.');
    }

    public function approveComment(BlogComment $comment)
    {
        $comment->update(['status' => 'approved']);
        return back()->with('success', 'Commentaire approuvé.');
    }

    public function disapproveComment(BlogComment $comment)
    {
        $comment->update(['status' => 'rejected']);
        return back()->with('success', 'Commentaire rejeté.');
    }

    public function destroyComment(BlogComment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Commentaire supprimé.');
    }
}
