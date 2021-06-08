<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkAdmin()
    {
        $admin = Admin::all();
        $isAdmin = False;
        for ($i = 0; $i < count($admin); $i++) {
            if (auth()->user()->ID_user == $admin[$i]->ID_user) {
                $isAdmin = True;
                break;
            }
        }
        return $isAdmin;
    }
    public function checkLecturer()
    {
        $lecturer = Lecturer::all();
        $isLecturer = False;
        for ($i = 0; $i < count($lecturer); $i++) {
            if (auth()->user()->ID_user == $lecturer[$i]->ID_user) {
                $isLecturer = True;
                break;
            }
        }
        return $isLecturer;
    }
    public function index()
    {
        if ($this->checkAdmin()) {
            return redirect()->route('admin.home');
        } elseif ($this->checkLecturer()) {
            return redirect()->route('lecturer.home');
        } else {
            return redirect()->route('user.home');
        }
    }
}
