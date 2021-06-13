<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ContactUs;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecturer;
use App\Models\Major;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function home()
    {
        $courses = Course::all();
        $majors = Major::all();
        return view('welcome', compact('courses', 'majors'));
    }
    public function redirectLogin()
    {
        return redirect()->route('login')->with('info', 'You have to Login First');
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
        $comments = ContactUs::where('show', 1)->get();
        return view('contactUs', compact('comments'));
    }
    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'subject' => 'required',
                'message' => 'required',
            ]);
            $contact_us = new ContactUs;
            $contact_us->name = $request->get('name');
            $contact_us->email = $request->get('email');
            $contact_us->subject = $request->get('subject');
            $contact_us->message = $request->get('message');
            $contact_us->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->back()->with('fail', $message);
        }
        $message = 'Sent Successfully, Thanks, We Are Looking Forwared to Hear From You Soon! :)';
        return redirect()->back()->with('success', $message);
    }
}
