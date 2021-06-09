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
}
