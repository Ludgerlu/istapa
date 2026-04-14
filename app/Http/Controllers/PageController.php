<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the home page
     */
    public function home()
    {
        return view('home');
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
        return view('blog');
    }

    /**
     * Display blog details page
     */
    public function blogDetails($id)
    {
        return view('blog-details');
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