<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Lecturer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if ($this->checkAdmin()) {
                return redirect()->back();
            } elseif ($this->checkLecturer()) {
                return redirect()->back();
            } else {
                return $next($request);
            }
        } else {
            return redirect()->back();
        }
    }
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
}
