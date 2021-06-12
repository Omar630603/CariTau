<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    public function editStudent(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->save();
        return redirect()->back();
    }
    public function editStudentImage(Request $request, User $user)
    {
        if ($user->image == "User_images/default.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
            $user->image = $image_name;
        } else {
            Storage::delete('public/' . $user->image);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
            $user->image = $image_name;
        }
        $user->save();
        return redirect()->back();
    }
    public function editStudentImageDefult(User $user)
    {
        if ($user->image == "User_images/default.png") {
            $user->image = 'User_images/default.png';
        } else {
            Storage::delete('public/' . $user->image);
            $user->image = 'User_images/default.png';
        }
        $user->save();
        return redirect()->back();
    }
    public function deleteStudent(User $user)
    {
        if ($user->image == "User_images/default.png") {
            $user->delete();
        } else {
            Storage::delete('public/' . $user->image);
            $user->delete();
        }
        return redirect()->route('/');
    }
}
