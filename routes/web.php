<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Amin\LeaveController as AdminLeaveController;
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

        // ── Users ─────────────────────────────────────────────────────────────
        Route::resource('users', UserController::class);

        // ── Attendance ────────────────────────────────────────────────────────
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/',                              [AttendanceController::class, 'index'])         ->name('index');
            Route::get('/mark',                          [AttendanceController::class, 'mark'])          ->name('mark');
            Route::post('/store',                        [AttendanceController::class, 'store'])         ->name('store');
            Route::get('/class-summary',                 [AttendanceController::class, 'classSummary'])  ->name('class-summary');
            Route::get('/student/{student}/report',      [AttendanceController::class, 'studentReport']) ->name('student-report');
        });

        // ── Fees ──────────────────────────────────────────────────────────────
        Route::prefix('fees')->name('fees.')->group(function () {
            Route::get('/',                              [FeesController::class, 'index'])           ->name('index');
            Route::get('/payment/create',                [FeesController::class, 'createPayment'])   ->name('create-payment');
            Route::post('/payment',                      [FeesController::class, 'storePayment'])    ->name('store-payment');
            Route::get('/student/{student}',             [FeesController::class, 'studentFees'])     ->name('student');
            Route::get('/receipt/{payment}',             [FeesController::class, 'receipt'])         ->name('receipt');
            Route::get('/structure',                     [FeesController::class, 'structure'])       ->name('structure');
            Route::put('/structure',                     [FeesController::class, 'updateStructure']) ->name('update-structure');
        });
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