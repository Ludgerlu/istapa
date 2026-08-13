<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\LeaveController as AdminLeaveController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\FeesController as AdminFeesController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\GalleryAlbumController as AdminGalleryAlbumController;
use App\Http\Controllers\Admin\GalleryImageController as AdminGalleryImageController;
use App\Http\Controllers\Admin\ClassController as AdminClassController;
USE App\Http\Controllers\Admin\AdmissionRequestController as AdminAdmissionRequestController;
use App\Http\Controllers\Admin\SubjectController as AdminSubjectController;
use App\Http\Controllers\Admin\ExamController as AdminExamController;
use App\Http\Controllers\Admin\ExamSubjectController as AdminExamSubjectController;
use App\Http\Controllers\Admin\MarkController as AdminMarkController;
use App\Http\Controllers\Admin\AcademicYearController as AdminAcademicYearController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
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
Route::post('/contact/store', [PageController::class, 'storeContact'])->name('contact.store');

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
        
        // ── Attendances ────────────────────────────────────────────────────────
        Route::resource('attendances', AdminAttendanceController::class);
        Route::get('attendances/get-subjects/{classId}', [AdminAttendanceController::class, 'getSubjectsByClassJson'])->name('attendances.getSubjects');
        Route::get('attendances/get-students/{classId}', [AdminAttendanceController::class, 'getStudentsByClassJson'])->name('attendances.getStudents');
        // ── Attendance ────────────────────────────────────────────────────────
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/',                              [AdminAttendanceController::class, 'index'])         ->name('index');
            Route::get('/mark',                          [AdminAttendanceController::class, 'mark'])          ->name('mark');
            Route::post('/store',                        [AdminAttendanceController::class, 'store'])         ->name('store');
            Route::get('/class-summary',                 [AdminAttendanceController::class, 'classSummary'])  ->name('class-summary');
            Route::get('/student/{student}/report',      [AdminAttendanceController::class, 'studentReport']) ->name('student-report');
        });

        // Classes
        Route::resource('classes', AdminClassController::class);
        Route::resource('subjects', AdminSubjectController::class);
        Route::resource('academic-years', AdminAcademicYearController::class);
        // Route::get('subjects/create?class_id={class_id}', [AdminSubjectController::class, 'create'])->name('subjects.create');
    
        // Attendance sessions (for presence list)
        Route::get('attendance-sessions/{session}/presence', [AdminClassController::class, 'showPresence'])->name('attendance-sessions.presence');

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
        // Route::resource('events', AdminEventController::class);
        Route::post('events/{event}/images', [AdminEventController::class, 'storeImage'])->name('events.storeImage');
        Route::delete('events/images/{image}', [AdminEventController::class, 'destroyImage'])->name('events.destroyImage');
        Route::post('events/images/reorder', [AdminEventController::class, 'reorderImages'])->name('events.reorderImages');

        //  ── Gallery Albums ────────────────────────────────────────────────────────
        Route::resource('gallery', AdminGalleryImageController::class);
                                                                                 
        // Image management
        Route::post('gallery/{id}/upload', [AdminGalleryImageController::class, 'upload'])->name('gallery.upload');
        Route::delete('gallery/image/{id}', [AdminGalleryImageController::class, 'deleteImage'])->name('gallery.image.delete');
        Route::post('gallery/{albumId}/cover/{imageId}', [AdminGalleryImageController::class, 'setCover'])->name('gallery.set-cover');
        Route::post('gallery/{albumId}/reorder', [AdminGalleryImageController::class, 'reorder'])->name('gallery.reorder');

        // ── Admission Requests ────────────────────────────────────────────────────────
        // Admission requests
        Route::get('admissions', [AdminAdmissionRequestController::class, 'index'])->name('admissions.index');
        Route::post('admissions/{admission}/approve', [AdminAdmissionRequestController::class, 'approve'])->name('admissions.approve');
        Route::post('admissions/{admission}/reject', [AdminAdmissionRequestController::class, 'reject'])->name('admissions.reject');
        Route::delete('admissions/{admission}', [AdminAdmissionRequestController::class, 'destroy'])->name('admissions.destroy');
        Route::get('admissions/{admission}', [AdminAdmissionRequestController::class, 'show'])->name('admissions.show');
        // Leave requests
        Route::get('leaves', [AdminLeaveController::class, 'index'])->name('leaves.index');
        Route::post('leaves/{leave}/approve', [AdminLeaveController::class, 'approve'])->name('leaves.approve');
        Route::post('leaves/{leave}/reject', [AdminLeaveController::class, 'reject'])->name('leaves.reject');
        Route::delete('leaves/{leave}', [AdminLeaveController::class, 'destroy'])->name('leaves.destroy');
        Route::get('leaves/{leave}', [AdminLeaveController::class, 'show'])->name('leaves.show');

        // ── Programs ──────────────────────────────────────────────────────²
        Route::resource('programs', AdminProgramController::class)->names('programs');
        
        // Exams
        Route::resource('exams', AdminExamController::class);
        
        // Manage exam subjects (add/remove)
        Route::post('exams/{exam}/subjects', [AdminExamSubjectController::class, 'store'])->name('exams.subjects.store');
        Route::delete('exam-subjects/{examSubject}', [AdminExamSubjectController::class, 'destroy'])->name('exams.subjects.destroy');
        
        // Marks entry
        Route::get('exam-subjects/{examSubject}/marks', [AdminMarkController::class, 'edit'])->name('exam-subjects.marks.edit');
        Route::put('exam-subjects/{examSubject}/marks', [AdminMarkController::class, 'update'])->name('exam-subjects.marks.update');
    
        Route::get('contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{message}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('contact-messages/{message}/mark-read', [AdminContactMessageController::class, 'markAsRead'])->name('contact-messages.mark-read');
        Route::patch('contact-messages/{message}/mark-unread', [AdminContactMessageController::class, 'markAsUnread'])->name('contact-messages.mark-unread');
        Route::delete('contact-messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    });


    Route::middleware(['role:manager'])->prefix('manager')->name('manager.')->group(function () {

        // Dashboard (optional – you can reuse AdminDashboardController or create a dedicated one)
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

        // ── Blog ──────────────────────────────────────────────────────
        Route::get('/blog',              [AdminBlogController::class, 'index'])->name('blogs.index');
        Route::get('/blog/create',       [AdminBlogController::class, 'create'])->name('blogs.create');
        Route::post('/blog',             [AdminBlogController::class, 'store'])->name('blogs.store');
        Route::get('/blog/{blog}',       [AdminBlogController::class, 'show'])->name('blogs.show');
        Route::get('/blog/{blog}/edit',  [AdminBlogController::class, 'edit'])->name('blogs.edit');
        Route::put('/blog/{blog}',       [AdminBlogController::class, 'update'])->name('blogs.update');
        Route::delete('/blog/{blog}',    [AdminBlogController::class, 'destroy'])->name('blogs.destroy');
        // Comment moderation
        Route::patch('comments/{comment}/approve',   [AdminBlogController::class, 'approveComment'])->name('comments.approve');
        Route::patch('comments/{comment}/disapprove',[AdminBlogController::class, 'disapproveComment'])->name('comments.disapprove');
        Route::delete('comments/{comment}',          [AdminBlogController::class, 'destroyComment'])->name('comments.destroy');

        // ── Programs ──────────────────────────────────────────────────────²
        Route::resource('programs', AdminProgramController::class)->names('programs');
        // Gallery endpoints
        Route::post('programs/{program}/images', [AdminProgramController::class, 'storeImage'])->name('programs.storeImage');
        Route::delete('programs/images/{image}', [AdminProgramController::class, 'destroyImage'])->name('programs.destroyImage');
        Route::post('programs/images/reorder', [AdminProgramController::class, 'reorderImages'])->name('programs.reorderImages');

        // ── Events ────────────────────────────────────────────────────
        Route::get('/events',             [AdminEventController::class, 'index'])->name('events.index');
        Route::get('/events/create',      [AdminEventController::class, 'create'])->name('events.create');
        Route::post('/events',            [AdminEventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}',     [AdminEventController::class, 'show'])->name('events.show');
        Route::get('/events/{event}/edit',[AdminEventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}',     [AdminEventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}',  [AdminEventController::class, 'destroy'])->name('events.destroy');
        // Event images
        Route::post('events/{event}/images',        [AdminEventController::class, 'storeImage'])->name('events.storeImage');
        Route::delete('events/images/{image}',      [AdminEventController::class, 'destroyImage'])->name('events.destroyImage');
        Route::post('events/images/reorder',        [AdminEventController::class, 'reorderImages'])->name('events.reorderImages');

        // ── Gallery ──────────────────────────────────────────────────
        // Using GalleryImageController (or GalleryController – choose one)
        Route::resource('gallery', AdminGalleryImageController::class);
        // Additional gallery routes
        Route::post('gallery/{id}/upload', [AdminGalleryImageController::class, 'upload'])->name('gallery.upload');
        Route::delete('gallery/image/{id}', [AdminGalleryImageController::class, 'deleteImage'])->name('gallery.image.delete');
        Route::post('gallery/{albumId}/cover/{imageId}', [AdminGalleryImageController::class, 'setCover'])->name('gallery.set-cover');
        Route::post('gallery/{albumId}/reorder', [AdminGalleryImageController::class, 'reorder'])->name('gallery.reorder');

        // ── Contact Messages ────────────────────────────────────────
        Route::get('contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{message}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('contact-messages/{message}/mark-read', [AdminContactMessageController::class, 'markAsRead'])->name('contact-messages.mark-read');
        Route::patch('contact-messages/{message}/mark-unread', [AdminContactMessageController::class, 'markAsUnread'])->name('contact-messages.mark-unread');
        Route::delete('contact-messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        // Profile (optional)
        Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('profile');
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