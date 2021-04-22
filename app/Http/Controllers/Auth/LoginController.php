<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Admin;
use App\Models\Lecturer;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }
    public function findUsername()
    {
        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }
    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'login' => 'required',
            'password' => 'required',
        ]);
        $admin = Admin::all();
        $isAdmin = False;
        $userAdmin = new Admin;
        $lecturer = Lecturer::all();
        $isLecturer = False;
        $errors = new MessageBag;
        if (auth()->attempt(array($this->username = $this->findUsername() => $input['login'], 'password' => $input['password']))) {
            for ($i = 0; $i < count($admin); $i++) {
                if (auth()->user()->ID_user == $admin[$i]->ID_user) {
                    $isAdmin = True;
                    $userAdmin = $admin[$i];
                    break;
                }
            }
            for ($i = 0; $i < count($lecturer); $i++) {
                if (auth()->user()->ID_user == $lecturer[$i]->ID_user) {
                    $isLecturer = True;
                    break;
                }
            }
            if ($isAdmin) {
                return redirect()->route('admin.home', ['userAdmin' => $userAdmin]);
            } elseif ($isLecturer) {
                return redirect()->route('lecturer.home');
            } else {
                return redirect()->route('user.home');
            }
        } else {
            $errors = new MessageBag(['WrongCredentials' => ['These credentials do not match our records.']]);
            return redirect()->back()->withErrors($errors);
        }
    }
}
