<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userCourse = User::find(Auth::user()->ID_user)->course()->get();
        return view('user.index', compact('userCourse'));
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function mycourse()
    {
        $userCourse = User::find(Auth::user()->ID_user)->course()->get();
        return view('user.mycourse', compact('userCourse'));
    }
}
