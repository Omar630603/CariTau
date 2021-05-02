<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAdmin = Admin::find(auth()->user()->ID_user);
        return view('admin.index', ['userAdmin' => $userAdmin]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
    public function authAdmin(Request $request)
    {
        $this->validate($request, [
            'privateKey' => 'required',
        ]);
        $errors = new MessageBag;
        $userAdmin = Admin::where('ID_user', 'like', '%' . auth()->user()->ID_user . '%')->first();
        echo $userAdmin;
        if ($userAdmin->privateKey == $request->privateKey) {
            return redirect()->route('admin.dashboard');
        } else {
            $errors = new MessageBag(['WrongCredentials' => ['These credentials do not match our records.']]);
            return redirect()->back()->withErrors($errors);
        }
    }
    public function dashboardAdmin()
    {
        return view('admin.dashboard');
    }
    public function usersAdmin()
    {
        $countLecturers = count(Lecturer::all());
        $countAdmins = count(Admin::all());
        $countStudents = count(User::all()) - $countAdmins - $countLecturers;
        $admin = Admin::pluck('ID_user')->all();
        $lecturer = Lecturer::pluck('ID_user')->all();
        $adminLecturer = array_merge($admin, $lecturer);
        $users = User::whereNotIn('ID_user', $adminLecturer)->select('name', 'username', 'email', 'phone', 'address')->paginate(10);
        $admins = Admin::Join('user', 'admin.ID_user', '=', 'user.ID_user', 'left outer')->paginate(10);
        $lecturers = Lecturer::Join('user', 'lecturer.ID_user', '=', 'user.ID_user', 'left outer')->paginate(10);
        $courses = Course::all();
        return view('admin.users', [
            'users' => $users, 'admins' => $admins, 'lecturers' => $lecturers, 'courses' => $courses,
            'countS' => $countStudents, 'countL' => $countLecturers, 'countA' => $countAdmins
        ]);
    }
    public function registerUserAdmin(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'password' => 'required',
            ]);
            $user = new User;
            $user->name = $request->get('name');
            $user->username = $request->get('username');
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->address = $request->get('address');
            $user->password =  Hash::make($request->get('password'));
            $user->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->route('admin.users')->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->route('admin.users')->with('success', $message);
    }
    public function registerLecturerAdmin(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'password' => 'required',
                'course' => 'required',
            ]);
            $user = new User;
            $user->name = $request->get('name');
            $user->username = $request->get('username');
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->address = $request->get('address');
            $user->password =  Hash::make($request->get('password'));
            $user->save();
            $course = new Course;
            $course->ID_course = $request->get('course');
            $lecturer = new Lecturer;
            $lecturer->user()->associate($user);
            $lecturer->course()->associate($course);
            $lecturer->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            $message .= $e;
            return redirect()->route('admin.users')->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->route('admin.users')->with('success', $message);
    }
    public function registerAdminAdmin(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'password' => 'required',
                'privateKey' => 'required',
            ]);
            $user = new User;
            $user->name = $request->get('name');
            $user->username = $request->get('username');
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->address = $request->get('address');
            $user->password =  Hash::make($request->get('password'));
            $user->save();
            $admin = new admin;
            $admin->user()->associate($user);
            $admin->privateKey = $request->get('privateKey');
            $admin->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            $message .= $e;
            return redirect()->route('admin.users')->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->route('admin.users')->with('success', $message);
    }
    public function lecturesAdmin()
    {
        return view('admin.lecturers');
    }
    public function majorsAdmin()
    {
        return view('admin.majors');
    }
    public function commentsAdmin()
    {
        return view('admin.comments');
    }
    public function othersAdmin()
    {
        return view('admin.others');
    }
}
