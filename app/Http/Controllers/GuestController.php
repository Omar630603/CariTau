<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function home()
    {
        $courses = Course::paginate(8);
        return view('welcome', compact('courses'));
    }
    public function aboutUs()
    {
        return view('aboutUs');
    }
    public function courses()
    {
        return view('courses');
    }
    public function lecturers()
    {
        return view('lecturers');
    }
    public function contactUs()
    {
        return view('contactUs');
    }
}
