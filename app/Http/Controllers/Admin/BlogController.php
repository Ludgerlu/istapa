<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\Event;


class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with('author')
            ->when($request->q,      fn($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15);

        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        $authors = User::admins()->orWhere('type', 'teacher')->orderBy('display_name')->get();
        return view('admin.blog.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'excerpt'     => 'nullable|string',
            'content'     => 'required|string',
            'status'      => 'required|in:draft,published,archived',
            'author_id'   => 'required|exists:users,id',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        // Auto-generate slug if empty
        // if (empty($data['slug'])) {
        //     $data['slug'] = \Str::slug($data['title']);
        // }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('blog', 'public');
        }

        Blog::create($data);

        return redirect()->route('admin.blogs')->with('success', 'Article créé avec succès.');
    }

    public function show(Blog $blog)
    {
        $blog->load('author');
        $recentPosts    = Blog::published()->where('id', '!=', $blog->id)->take(5)->get();
        $upcomingEvents = Event::upcoming()->take(4)->get();
        $previous       = Blog::published()->where('id', '<', $blog->id)->first();
        $next           = Blog::published()->where('id', '>', $blog->id)->first();

        return view('admin.blog.show', compact('blog', 'recentPosts', 'upcomingEvents', 'previous', 'next'));
    }

    public function edit(Blog $blog)
    {
        $authors = User::where('type', 'admin')->orWhere('type', 'teacher')->orderBy('display_name')->get();
        return view('admin.blog.edit', compact('blog', 'authors'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:posts,slug,' . $blog->id,
            'excerpt'     => 'nullable|string',
            'content'     => 'required|string',
            'status'      => 'required|in:draft,published,archived',
            'author_id'   => 'required|exists:users,id',
            'cover_image' => 'nullable|image|max:2048',
            'remove_cover'=> 'nullable|boolean',
        ]);

        if ($request->boolean('remove_cover') && $blog->cover_image) {
            \Storage::disk('public')->delete($blog->cover_image);
            $data['cover_image'] = null;
        }

        if ($request->hasFile('cover_image')) {
            if ($blog->cover_image) {
                \Storage::disk('public')->delete($blog->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('blog', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blogs')->with('success', 'Article mis à jour.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->cover_image) {
            \Storage::disk('public')->delete($blog->cover_image);
        }
        $blog->delete();

        return redirect()->route('admin.blogs')->with('success', 'Article supprimé.');
    }
}
