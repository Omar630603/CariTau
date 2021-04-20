<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Lecturer;


class LecturerAccess
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
        $lecturer = Lecturer::all();
        $isLecturer = False;
        for ($i = 0; $i < count($lecturer); $i++) {
            if (auth()->user()->ID_user == $lecturer[$i]->ID_user) {
                $isLecturer = True;
                break;
            }
        }
        if ($isLecturer) {
            return $next($request);
        } else {
            return redirect('home')->with('error', "You don't have admin access.");
        }
    }
}
