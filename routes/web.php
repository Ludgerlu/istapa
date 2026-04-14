<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

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