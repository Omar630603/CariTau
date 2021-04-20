<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;

class AdminAccess
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
        $admin = Admin::all();
        $isAdmin = False;
        for ($i = 0; $i < count($admin); $i++) {
            if (auth()->user()->ID_user == $admin[$i]->ID_user) {
                $isAdmin = True;
                break;
            }
        }
        if ($isAdmin) {
            return $next($request);
        } else {
            return redirect('home')->with('error', "You don't have admin access.");
        }
    }
}
