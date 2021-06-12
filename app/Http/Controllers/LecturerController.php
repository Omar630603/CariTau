<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lecturer.index');
    }
    public function profile()
    {
        return view('lecturer.profile');
    }

    public function course()
    {
        return view('lecturer.course');
    }
}
