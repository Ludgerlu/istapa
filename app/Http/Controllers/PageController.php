<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Event;
use App\Models\Testimonial;
use App\Models\UpcomingSession;


class PageController extends Controller
{
    /**
     * Display the home page
     */
    public function home()
    {
         // Latest 3 blog posts
        $latestBlogs = BlogPost::published()->latest()->limit(3)->get();

        // Upcoming events (start_date >= today, published) – limit 3
        $upcomingEvents = Event::where('is_published', true)
            ->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        // Published testimonials – limit 5
        $testimonials = Testimonial::published()->limit(5)->get();

        // Upcoming sessions – limit 3
        // $upcomingSessions = UpcomingSession::published()->limit(3)->get();

        return view('home', compact('latestBlogs', 'upcomingEvents', 'testimonials'));
    }

    /**
     * Display the about page - Founder's Message
     */
    public function aboutFounder()
    {
        return view('about');
    }

    /**
     * Display the about page - Establishment
     */
    public function aboutEstablishment()
    {
        return view('about-two');
    }

    /**
     * Display the courses page (grid view)
     */
    public function courses()
    {
        return view('course');
    }

    /**
     * Display the courses list view
     */
    public function coursesList()
    {
        return view('course-list-view');
    }

    /**
     * Display course details
     */
    public function courseDetails($id)
    {
        return view('course-details');
    }

    /**
     * Display lesson details
     */
    public function lessonDetails($id)
    {
        return view('lesson-details');
    }

    /**
     * Display blog page
     */
    public function blog()
    {
        $blogs = BlogPost::published()->latest()->paginate(6);
        // dd($blogs);
        return view('blog', compact('blogs'));
    }

    /**
     * Display blog details page
     */
    public function blogDetails($id)
    {
        // Get the blog post with its author, category, and comments
        $post = BlogPost::with(['author', 'category', 'comments.user'])
            ->published()
            ->where('id', $id)
            ->firstOrFail();

        // Increment view count
        $post->increment('view_count');

        // Get related posts: same category, excluding current, published, limit 3
        $relatedPosts = BlogPost::published()
            ->where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        // For comments, we only show approved ones
        $comments = $post->comments()->where('is_approved', true)->with('user')->get();

        return view('blog-details', compact('post', 'relatedPosts', 'comments'));
    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|min:3',
        ]);

        $comment = new BlogComment();
        $comment->blog_post_id = $postId;
        $comment->user_id = Auth::id(); // Requires authentication
        $comment->content = $request->content;
        $comment->is_approved = true; // Auto-approve, or set false for moderation
        $comment->created_at = now();
        $comment->save();

        return back()->with('success', 'Commentaire ajouté avec succès.');
    }


    /**
     * Display admission page
     */
    public function admission()
    {
        return view('apply-admission');
    }

    /**
     * Display gallery page
     */
    public function gallery()
    {
        return view('gallery');
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Display FAQ page
     */
    public function faq()
    {
        return view('faq');
    }

    /**
     * Display events page
     */
    public function events()
    {
        return view('events');
    }

    /**
     * Display event details page
     */
    public function eventDetails($id)
    {
        return view('event-details');
    }

    /**
     * Display sign in page
     */
    public function signIn()
    {
        return view('sign-in');
    }

    /**
     * Display sign up page
     */
    public function signUp()
    {
        return view('sign-up');
    }
}