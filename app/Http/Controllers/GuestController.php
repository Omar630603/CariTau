<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecturer;
use App\Models\User;
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
        $courses = count(Course::all());
        $enrollment = count(Enrollment::all());
        $lecturers = count(Lecturer::all());
        $countAdmins = count(Admin::all());
        $students = count(User::all()) - $countAdmins - $lecturers;
        return view('aboutUs', compact('courses', 'enrollment', 'students', 'lecturers'));
    }
    public function courses(Request $request)
    {
        $search = $request->get('search');
        if ($request->get('search')) {
            $courses = Course::search(['course_name'], $search)->get();
        } else {
            $courses = Course::all();
        }
        return view('courses', compact('courses', 'search'));
    }
    public function lecturers()
    {
        $lecturers = Lecturer::Join('user', 'lecturer.ID_user', '=', 'user.ID_user', 'left outer')->get();
        $courses = Course::all();
        return view('lecturers', compact('lecturers', 'courses'));
    }
    public function contactUs()
    {
        return view('contactUs');
    }
}
