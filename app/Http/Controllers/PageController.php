<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Classes;
use App\Models\Program;
use App\Models\BlogPost;
use App\Models\Testimonial;
use App\Models\BlogComment;
use App\Models\GalleryAlbum;
use App\Models\BlogCategory;
use App\Models\UpcomingSession;
use App\Models\AdmissionRequest;
use App\Models\AdmissionDocument;
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
         // Latest 5 blog posts
        $latestBlogs = BlogPost::published()->latest()->limit(5)->get();

        // Upcoming events (start_date >= today, published) – limit 3
        $upcomingEvents = Event::where('is_published', true)
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
        $programs = Program::published()->with('classes')->get();
        

        return view('course', compact('courses', 'programs'));
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

        $program = Program::where('id', $id)
            ->where('is_published', 1)
            ->firstOrFail();
        
        // Get classes for this program with their levels and academic years
        $classes = Classes::with(['program', 'academicYear', 'headTeacher'])
            ->where('program_id', $program->id)
            ->get();
        
        
        // Get testimonials related to this program (optional - you may need to add program_id to testimonials table)
        $testimonials = \App\Models\Testimonial::where('is_published', 1)
            ->orderBy('sort_order')
            ->take(3)
            ->get();
        
        // Get admission requests count for this program (optional)
        $activeStudentsCount = \App\Models\AdmissionRequest::where('program_id', $program->id)
            ->where('status', 'accepted')
            ->count();
        return view('course-details', compact('program', 'testimonials', 'activeStudentsCount'));
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
         $albums = GalleryAlbum::with(['images' => function ($query) {
            $query->orderBy('sort_order', 'asc');
        }])->orderBy('sort_order', 'asc')->get();

        return view('gallery', compact('albums'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Store a new contact message.
     */
    public function storeContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Veuillez corriger les erreurs ci-dessous.'
            ], 422);
        }

        ContactMessage::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread',
            'ip_address' => $request->ip(),
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Votre message a été envoyé avec succès ! Nous vous répondrons sous 24h.'
        ]);
    }

    /**
     * Display FAQ page
     */
    public function faq()
    {
        return view('faq');
    }

    /**
     * Display events page with paginated list
     */
    public function events()
    {
        // Get published events, upcoming first (start_date >= today), order by start_date ASC
        $events = Event::where('is_published', true)
            ->orderBy('start_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(6); // 6 events per page
    
        $events->increment('view_count');


        return view('events', compact('events'));
    }

    /**
     * Display single event details page
     */
    public function eventDetails($id)
    {
        
        $event = Event::with(['images'])->where('is_published', true)->findOrFail($id);
        // $event->increment('views');

        return view('event-details', compact('event'));
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