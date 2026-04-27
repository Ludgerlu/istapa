<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Amin\LeaveController as AdminLeaveController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\FeesController as AdminFeesController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\GalleryAlbumController as AdminGalleryAlbumController;
use App\Http\Controllers\Admin\GalleryImageController as AdminGalleryImageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', [PageController::class, 'home'])->name('home');

// About pages
Route::prefix('about')->group(function () {
    Route::get('/founder', [PageController::class, 'aboutFounder'])->name('about.founder');
    Route::get('/establishment', [PageController::class, 'aboutEstablishment'])->name('about.establishment');
});

// Course pages
Route::prefix('courses')->group(function () {
    Route::get('/', [PageController::class, 'courses'])->name('courses');
    Route::get('/list', [PageController::class, 'coursesList'])->name('courses.list');
    Route::get('/{id}', [PageController::class, 'courseDetails'])->name('course.details');
    Route::get('/lesson/{id}', [PageController::class, 'lessonDetails'])->name('lesson.details');
});

// Blog pages
Route::prefix('blog')->group(function () {
    Route::get('/', [PageController::class, 'blog'])->name('blog');
    Route::get('/{id}', [PageController::class, 'blogDetails'])->name('blog.details');
    Route::post('/blog/{postId}/comment', [PageController::class, 'storeComment'])->name('blog.comment.store')->middleware('auth');
});

// Admission page
Route::get('/admission', [PageController::class, 'admission'])->name('admission');
Route::post('/admission', [PageController::class, 'storeAdmission'])->name('admission.store');

// Gallery page
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');

// Contact page
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// FAQ page
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

// Events pages
Route::prefix('events')->group(function () {
    Route::get('/', [PageController::class, 'events'])->name('events');
    Route::get('/{id}', [PageController::class, 'eventDetails'])->name('event.details');
});

// Authentication pages
Route::get('/sign-in', [PageController::class, 'signIn'])->name('signin');
Route::get('/sign-up', [PageController::class, 'signUp'])->name('signup');
// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route::post('/register', [RegisterController::class, 'register']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('profile');


        // Leave approvals
        Route::patch('/leaves/{leave}/approve', [AdminLeaveController::class, 'approveLeave'])->name('leaves.approve');
        Route::patch('/leaves/{leave}/reject',  [AdminLeaveController::class, 'rejectLeave'])->name('leaves.reject');

        // ── Blog CRUD ──────────────────────────────────────────────────────────
        Route::get('/blog',              [AdminBlogController::class, 'index'])->name('blogs.index');
        Route::get('/blog/create',       [AdminBlogController::class, 'create'])->name('blogs.create');
        Route::post('/blog',             [AdminBlogController::class, 'store'])->name('blogs.store');
        Route::get('/blog/{blog}',       [AdminBlogController::class, 'show'])->name('blogs.show');
        Route::get('/blog/{blog}/edit',  [AdminBlogController::class, 'edit'])->name('blogs.edit');
        Route::put('/blog/{blog}',       [AdminBlogController::class, 'update'])->name('blogs.update');
        Route::delete('/blog/{blog}',    [AdminBlogController::class, 'destroy'])->name('blogs.destroy');
        // Comment moderation (nested under blogs, but can be separate)
        Route::patch('comments/{comment}/approve', [AdminBlogController::class, 'approveComment'])->name('comments.approve');
        Route::patch('comments/{comment}/disapprove', [AdminBlogController::class, 'disapproveComment'])->name('comments.disapprove');
        Route::delete('comments/{comment}', [AdminBlogController::class, 'destroyComment'])->name('comments.destroy');

        // ── Users ─────────────────────────────────────────────────────────────
        Route::resource('users', AdminUserController::class);

        // ── Attendance ────────────────────────────────────────────────────────
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/',                              [AdminAttendanceController::class, 'index'])         ->name('index');
            Route::get('/mark',                          [AdminAttendanceController::class, 'mark'])          ->name('mark');
            Route::post('/store',                        [AdminAttendanceController::class, 'store'])         ->name('store');
            Route::get('/class-summary',                 [AdminAttendanceController::class, 'classSummary'])  ->name('class-summary');
            Route::get('/student/{student}/report',      [AdminAttendanceController::class, 'studentReport']) ->name('student-report');
        });

        // ── Fees ──────────────────────────────────────────────────────────────
        Route::resource('fees', AdminFeesController::class);
        Route::prefix('fees')->name('fees.')->group(function () {
            Route::get('/payment/create',                [AdminFeesController::class, 'createPayment'])   ->name('create-payment');
            Route::post('/payment',                      [AdminFeesController::class, 'storePayment'])    ->name('store-payment');
            Route::get('/student/{student}',             [AdminFeesController::class, 'studentFees'])     ->name('student');
            Route::get('/receipt/{payment}',             [AdminFeesController::class, 'receipt'])         ->name('receipt');
            Route::get('/structure',                     [AdminFeesController::class, 'structure'])       ->name('structure');
            Route::put('/structure',                     [AdminFeesController::class, 'updateStructure']) ->name('update-structure');
        });

         // ── Events ──────────────────────────────────────────────────────────
        Route::resource('events', AdminEventController::class);
        Route::post('events/{event}/images', [AdminEventController::class, 'storeImage'])->name('events.storeImage');
        Route::delete('events/images/{image}', [AdminEventController::class, 'destroyImage'])->name('events.destroyImage');
        Route::post('events/images/reorder', [AdminEventController::class, 'reorderImages'])->name('events.reorderImages');

        //  ── Gallery Albums ────────────────────────────────────────────────────────
        Route::resource('gallery', AdminGalleryAlbumController::class);
        Route::post('gallery/{album}/images', [AdminGalleryImageController::class, 'store'])->name('gallery.images.store');
        Route::delete('gallery/images/{image}', [AdminGalleryImageController::class, 'destroy'])->name('gallery.images.destroy');
        Route::post('gallery/images/reorder', [AdminGalleryImageController::class, 'reorder'])->name('gallery.images.reorder');
    
    });

    // Student Routes
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/payments', [StudentController::class, 'payments'])->name('payments');
        Route::get('/attendance', [StudentController::class, 'attendance'])->name('attendance');
        Route::get('/grades', [StudentController::class, 'grades'])->name('grades');
        Route::get('/leave-request', [StudentController::class, 'leaveRequest'])->name('leave.request');
        Route::post('/leave-request', [StudentController::class, 'submitLeaveRequest'])->name('leave.submit');
    });

    // Teacher Routes
    Route::middleware(['role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('/attendance/{classId}/{sectionId?}', [TeacherController::class, 'attendance'])->name('attendance');
        Route::post('/attendance', [TeacherController::class, 'storeAttendance'])->name('attendance.store');
        Route::get('/marks/{classId}/{subjectId}/{examId}', [TeacherController::class, 'marks'])->name('marks');
        Route::post('/marks', [TeacherController::class, 'storeMarks'])->name('marks.store');
    });
});