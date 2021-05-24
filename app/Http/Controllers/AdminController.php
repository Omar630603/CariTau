<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecturer;
use App\Models\Major;
use App\Models\Material;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
    public function authAdmin(Request $request)
    {
        $this->validate($request, [
            'privateKey' => 'required',
        ]);
        $errors = new MessageBag;
        $userAdmin = Admin::where('ID_user', 'like', '%' . auth()->user()->ID_user . '%')->first();
        if ($userAdmin->privateKey == $request->privateKey) {
            return redirect()->route('admin.dashboard');
        } else {
            $errors = new MessageBag(['WrongCredentials' => ['These credentials do not match our records.']]);
            return redirect()->back()->withErrors($errors);
        }
    }
    public function dashboardAdmin()
    {
        return view('Admin.dashboard');
    }
    public function usersAdmin()
    {
        $countLecturers = count(Lecturer::all());
        $countAdmins = count(Admin::all());
        $countStudents = count(User::all()) - $countAdmins - $countLecturers;
        $admin = Admin::pluck('ID_user')->all();
        $lecturer = Lecturer::pluck('ID_user')->all();
        $adminLecturer = array_merge($admin, $lecturer);
        $users = User::whereNotIn('ID_user', $adminLecturer)->paginate(10);
        $admins = Admin::Join('user', 'admin.ID_user', '=', 'user.ID_user', 'left outer')->paginate(10);
        $lecturers = Lecturer::Join('user', 'lecturer.ID_user', '=', 'user.ID_user', 'left outer')->paginate(10);
        $courses = Course::all();
        $lecturerCourses = Lecturer::pluck('ID_course')->all();
        $availableCourses = json_decode(json_encode($lecturerCourses), true);
        return view('admin.users', [
            'users' => $users, 'admins' => $admins, 'lecturers' => $lecturers, 'courses' => $courses,
            'countS' => $countStudents, 'countL' => $countLecturers, 'countA' => $countAdmins, 'availableCourses' => $availableCourses
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
    public function search()
    {
        $admins = Admin::pluck('ID_user')->all();
        $lecturers = Lecturer::pluck('ID_user')->all();
        $adminLecturers = array_merge($admins, $lecturers);
        $name = $_GET['search'];
        $searchResults = User::search(['name', 'username', 'email', 'phone', 'address'], $name)->get();
        return view('Admin.searchResults', compact('searchResults', 'admins', 'lecturers', 'adminLecturers'));
    }
    public function showUser(User $user)
    {
        $admins = Admin::pluck('ID_user')->all();
        $lecturers = Lecturer::pluck('ID_user')->all();
        $adminLecturers = array_merge($admins, $lecturers);
        $userCourse = User::find($user->ID_user)->course()->get();
        $availableCourse = User::find($user->ID_user)->course()->pluck('course.ID_course');
        $availableCourses = json_decode(json_encode($availableCourse), true);
        $lecturerID = Lecturer::where('ID_user', '=', $user->ID_user)->pluck('ID_lecturer');
        $lecturerCourse = new Lecturer;
        $courses = Course::all();
        if (!$lecturerID->isEmpty()) {
            $lecturerCourse = Lecturer::find($lecturerID)->first()->course()->get();
        }
        return view('Admin.userDetails', compact('user', 'admins', 'lecturers', 'adminLecturers', 'userCourse', 'lecturerCourse', 'courses', 'availableCourses'));
    }
    public function editUser(Request $request, User $user)
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
        return redirect()->route('admin.userDetails', $user);
    }
    public function editUserImage(Request $request, User $user)
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
        return redirect()->route('admin.userDetails', $user);
    }
    public function editUserImageDefult(User $user)
    {
        if ($user->image == "User_images/default.png") {
            $user->image = 'User_images/default.png';
        } else {
            Storage::delete('public/' . $user->image);
            $user->image = 'User_images/default.png';
        }
        $user->save();
        return redirect()->route('admin.userDetails', $user);
    }
    public function deleteUser(User $user)
    {
        if ($user->image == "User_images/default.png") {
            $user->delete();
        } else {
            Storage::delete('public/' . $user->image);
            $user->delete();
        }
        return redirect()->route('admin.users');
    }
    public function addCourseUser(Request $request, User $user)
    {
        $course = new Course;
        $course->ID_course = $request->get('course');
        $status = $request->get('status');
        $user->course()->attach($course, ['status' => $status]);
        return redirect()->route('admin.userDetails', $user);
    }
    public function deleteCourseUser(User $user, Course $Course)
    {
        $user->course()->detach($Course);
        return redirect()->route('admin.userDetails', $user);
    }
    public function editCourseUser(Request $request, User $user, Course $Course)
    {
        if ($request->get('status') != null) {
            $enrollment = Enrollment::where('ID_user', '=', $user->ID_user)->where('ID_course', '=', $Course->ID_course)->first();
            $enrollment->status = $request->get('status');
            $enrollment->save();
        }
        return redirect()->route('admin.userDetails', $user);
    }
    public function lecturesAdmin()
    {
        $lecturers = Lecturer::Join('user', 'lecturer.ID_user', '=', 'user.ID_user', 'left outer')->get();
        $courses = Course::all();
        $lecturerCourses = Lecturer::pluck('ID_course')->all();
        $availableCourses = json_decode(json_encode($lecturerCourses), true);
        return view('admin.lecturers', compact('lecturers', 'courses', 'availableCourses'));
    }
    public function majorsAdmin()
    {
        $majors = Major::all();
        $courses = Course::all();
        $lecturers = Lecturer::Join('user', 'lecturer.ID_user', '=', 'user.ID_user', 'left outer')->get();
        return view('admin.majors', compact('majors', 'courses', 'lecturers'));
    }
    public function majorAdmin(Major $major)
    {
        $courses = Course::select('*', 'course.description', 'course.image')->Join('major', 'course.ID_major', '=', 'major.ID_major', 'left outer')->where('course.ID_major', '=', $major->ID_major)->get();
        $lecturers = Lecturer::Join('user', 'lecturer.ID_user', '=', 'user.ID_user', 'left outer')->get();
        $materials = Material::all();
        return view('admin.majorEdit', compact('major', 'courses', 'lecturers', 'materials'));
    }
    public function addMajorAdmin(Request $request)
    {
        try {
            $request->validate([
                'major_name' => 'required',
                'description' => 'required',
            ]);
            $major = new Major;
            $major->major_name = $request->get('major_name');
            $major->description = $request->get('description');
            $major->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->route('admin.majors')->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->route('admin.majors')->with('success', $message);
    }
    public function editMajor(Request $request, Major $major)
    {
        $request->validate([
            'major_name' => 'required',
        ]);
        if ($request->get('description')) {
            $major->description = $request->get('description');
        }
        $major->major_name = $request->get('major_name');
        $major->save();
        return redirect()->route('admin.major', $major);
    }
    public function editMajorImage(Request $request, Major $major)
    {
        if ($major->image == "Major_images/default.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('Major_images', 'public');
            }
            $major->image = $image_name;
        } else {
            Storage::delete('public/' . $major->image);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('Major_images', 'public');
            }
            $major->image = $image_name;
        }
        $major->save();
        return redirect()->route('admin.major', $major);
    }
    public function editMajorImageDefult(Major $major)
    {
        if ($major->image == "Major_images/default.png") {
            $major->image = 'Major_images/default.png';
        } else {
            Storage::delete('public/' . $major->image);
            $major->image = 'Major_images/default.png';
        }
        $major->save();
        return redirect()->route('admin.major', $major);
    }
    public function deleteMajor(Major $major)
    {
        if ($major->image == "Major_images/default.png") {
            $major->delete();
        } else {
            Storage::delete('public/' . $major->image);
            $major->delete();
        }
        return redirect()->route('admin.majors');
    }
    public function addMajorCourseAdmin(Request $request, Major $major)
    {
        try {
            $request->validate([
                'course_name' => 'required',
                'description' => 'required',
                'price' => 'required',
            ]);
            $course = new Course;
            $course->major()->associate($major);
            $course->course_name = $request->get('course_name');
            $course->description = $request->get('description');
            $course->price = $request->get('price');
            $course->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->route('admin.major', $major)->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->route('admin.major', $major)->with('success', $message);
    }
    public function noCourseMajorsAdmin()
    {
        $message = 'You have to add the course in the right major or create a new one';
        return redirect()->route('admin.majors')->with('add', $message);
    }
    public function showCourse(Course $course)
    {
        $majors = Major::all();
        $materials = Material::all();
        $lecturerID = Lecturer::where('ID_course', '=', $course->ID_course)->get();
        if ($lecturerID->first()) {
            $lecturer = User::where('ID_user', '=', $lecturerID[0]->ID_user)->get();
            return view('admin.courseEdit', compact('course', 'lecturer', 'materials', 'majors'));
        } else {
            $lecturer = 'no lecturer';
            return view('admin.courseEdit', compact('course', 'lecturer', 'materials', 'majors'));
        }
    }
    public function editCourse(Request $request, Course $course)
    {

        $request->validate([
            'major' => 'required',
            'course_name' => 'required',
            'price' => 'required',
        ]);
        $course->ID_major = $request->get('major');
        $course->course_name = $request->get('course_name');
        if ($request->get('description')) {
            $course->description = $request->get('description');
        }
        $course->price = $request->get('price');
        $course->save();
        return redirect()->route('admin.courseDetails', $course);
    }
    public function editCourseImage(Request $request, Course $course)
    {
        if ($course->image == "Course_images/default.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('Course_images', 'public');
            }
            $course->image = $image_name;
        } else {
            Storage::delete('public/' . $course->image);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('Course_images', 'public');
            }
            $course->image = $image_name;
        }
        $course->save();
        return redirect()->route('admin.courseDetails', $course);
    }
    public function editCourseImageDefult(Course $course)
    {
        if ($course->image == "Course_images/default.png") {
            $course->image = 'Course_images/default.png';
        } else {
            Storage::delete('public/' . $course->image);
            $course->image = 'Course_images/default.png';
        }
        $course->save();
        return redirect()->route('admin.courseDetails', $course);
    }
    public function deleteCourse(Course $course, Major $major)
    {
        if ($course->image == "Course_images/default.png") {
            $course->delete();
        } else {
            Storage::delete('public/' . $course->image);
            $course->delete();
        }
        return redirect()->route('admin.major', $major);
    }
    public function addMaterialCourseAdmin(Request $request, Course $course)
    {
        try {
            $request->validate([
                'material_name' => 'required',
                'description' => 'required',
            ]);
            $material = new Material;
            $material->course()->associate($course);
            $material->material_name = $request->get('material_name');
            $material->description = $request->get('description');
            $material->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->route('admin.courseDetails', $course)->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->route('admin.courseDetails', $course)->with('success', $message);
    }
    public function showMaterial(Material $material)
    {
        $courses = Course::all();
        $course = Course::where('ID_course', '=', $material->ID_course)->first();
        $lecturerID = Lecturer::where('ID_course', '=', $course->ID_course)->get();
        if ($lecturerID->first()) {
            $lecturer = User::where('ID_user', '=', $lecturerID[0]->ID_user)->get();
            return view('admin.materialEdit', compact('material', 'lecturer', 'courses'));
        } else {
            $lecturer = 'no lecturer';
            return view('admin.materialEdit', compact('material', 'lecturer', 'courses'));
        }
    }
    public function editMaterial(Request $request, Material $material)
    {

        $request->validate([
            'course' => 'required',
            'material_name' => 'required',
        ]);
        $material->ID_course = $request->get('course');
        $material->material_name = $request->get('material_name');
        if ($request->get('description')) {
            $material->description = $request->get('description');
        }
        $material->save();
        return redirect()->route('admin.materialDetails', $material);
    }
    public function editMaterialImage(Request $request, Material $material)
    {
        if ($material->image == "Material_images/default.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('Material_images', 'public');
            }
            $material->image = $image_name;
        } else {
            Storage::delete('public/' . $material->image);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('Material_images', 'public');
            }
            $material->image = $image_name;
        }
        $material->save();
        return redirect()->route('admin.materialDetails', $material);
    }
    public function editMaterialImageDefult(Material $material)
    {
        if ($material->image == "Material_images/default.png") {
            $material->image = 'Material_images/default.png';
        } else {
            Storage::delete('public/' . $material->image);
            $material->image = 'Material_images/default.png';
        }
        $material->save();
        return redirect()->route('admin.materialDetails', $material);
    }
    public function deleteMaterial(Material $material, Course $course)
    {
        if ($material->image == "Material_images/default.png") {
            $material->delete();
        } else {
            Storage::delete('public/' . $material->image);
            $material->delete();
        }
        return redirect()->route('admin.courseDetails', $course);
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
