<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Event;
use App\Models\Testimonial;
use App\Models\UpcomingSession;
use App\Models\Classes;
use App\Models\AdmissionRequest;
use App\Models\AdmissionDocument;
use App\Models\Program;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



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
        $courses = Classes::with(['program', 'academicYear', 'headTeacher', 'classEnrollments'])->latest()->get();
        return view('course', compact('courses'));
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
        $programs = Program::get();
        return view('apply-admission', compact('programs'));
    }

    public function storeAdmission(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|max:150|unique:admission_requests,email',
            'phone'      => 'required|string|max:30',
            'birth_date' => 'required|date',
            'gender'     => 'required|in:M,F',
            'country'    => 'required|string|max:100',
            'city'       => 'required|string|max:100',
            'address'    => 'nullable|string',
            'program_id' => 'required|exists:programs,id',
            'previous_school'   => 'nullable|string|max:200',
            'previous_diploma'  => 'nullable|string|max:200',
            'motivation'        => 'nullable|string',
            'documents'   => 'nullable|array',
            'documents.cv'   => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'documents.diploma' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'documents.id'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'documents.photo'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Generate unique reference code
        $referenceCode = 'ISTAPA-' . strtoupper(Str::random(10));
        while (AdmissionRequest::where('reference_code', $referenceCode)->exists()) {
            $referenceCode = 'ISTAPA-' . strtoupper(Str::random(10));
        }

        // Create admission request
        $admission = AdmissionRequest::create([
            'reference_code'    => $referenceCode,
            'first_name'        => $validated['first_name'],
            'last_name'         => $validated['last_name'],
            'email'             => $validated['email'],
            'phone'             => $validated['phone'],
            'birth_date'        => $validated['birth_date'],
            'gender'            => $validated['gender'],
            'address'           => $validated['address'] ?? null,
            'city'              => $validated['city'],
            'country'           => $validated['country'],
            'program_id'        => $validated['program_id'],
            'previous_school'   => $validated['previous_school'] ?? null,
            'previous_diploma'  => $validated['previous_diploma'] ?? null,
            'motivation'        => $validated['motivation'] ?? null,
            'status'            => 'pending',  // default status
        ]);

        // Handle document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $type => $file) {
                $path = $file->store('admission_documents/' . $admission->id, 'public');
                AdmissionDocument::create([
                    'admission_request_id' => $admission->id,
                    'doc_type'             => $type,
                    'file_path'            => $path,
                    'original_name'        => $file->getClientOriginalName(),
                ]);
            }
        };

        return back()->with('success', 'success', 'Votre candidature a été enregistrée avec succès. Votre référence : ' . $referenceCode);
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