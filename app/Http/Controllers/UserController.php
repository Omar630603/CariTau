<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\File;
use App\Models\Forum;
use App\Models\Major;
use App\Models\Material;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Video;
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
    public function course(Course $course)
    {
        $enrollment = Enrollment::where('ID_user', '=', Auth::user()->ID_user)->where('ID_course', '=', $course->ID_course)->first();
        $major = Major::where('ID_major', '=', $course->ID_major)->first();
        $courses = Course::where('ID_major', '=', $course->ID_major)->get();
        $materials = Material::where('ID_course', '=', $course->ID_course)->orderBy('order', 'ASC')->get();
        // echo $major;
        // echo Auth::user();
        // echo $course;
        // echo $enrollment;

        return view('user.course', compact('enrollment', 'major', 'course', 'courses', 'materials'));
    }
    public function enroll(Course $course)
    {
        $user = User::where('ID_user', Auth::user()->ID_user)->first();
        $user->course()->attach($course, ['status' => 0]);
        return redirect()->back();
    }
    public function unenroll(Course $course)
    {
        $user = User::where('ID_user', Auth::user()->ID_user)->first();
        $user->course()->detach($course);
        return redirect()->back();
    }
    public function material(Course $course, Material $material)
    {
        $materials = Material::where('ID_course', '=', $course->ID_course)->orderBy('order', 'ASC')->get();
        $enrollment = Enrollment::where('ID_user', '=', Auth::user()->ID_user)->where('ID_course', '=', $course->ID_course)->first();
        $courses = Course::where('ID_major', '=', $course->ID_major)->get();
        $files = File::where('ID_material', '=', $material->ID_material)->get();
        $videos = Video::where('ID_material', '=', $material->ID_material)->get();
        $quizzes = Quiz::where('ID_material', '=', $material->ID_material)->get();
        $forums = Forum::where('ID_material', '=', $material->ID_material)->get();
        if ($quizzes->first()) {
            $questions = Question::where('ID_quiz', '=', $quizzes->first()->ID_quiz)->get();
        } else {
            $questions = new Question;
        }
        return view('user.material', compact('enrollment', 'course', 'courses', 'materials', 'material', 'files', 'videos', 'quizzes', 'forums', 'questions'));
    }
    public function downloadFile(File $file)
    {
        return Storage::download('public/' . $file->file_name, $file->file_title . '.' . $file->file_extension);
    }
    public function showFile(File $file)
    {
        $file = File::where('ID_file', '=', $file->ID_file)->first();
        $url =  storage_path('app/public/' . $file->file_name);
        return response()->file($url);
    }
    public function showForum(Forum $forum, Course $course, Material $material)
    {
        $materials = Material::where('ID_course', '=', $course->ID_course)->orderBy('order', 'ASC')->get();
        $enrollment = Enrollment::where('ID_user', '=', Auth::user()->ID_user)->where('ID_course', '=', $course->ID_course)->first();
        $courses = Course::where('ID_major', '=', $course->ID_major)->get();
        return view('user.showForum', compact('forum', 'material', 'enrollment', 'course', 'courses', 'materials'));
    }
    public function addForumComment(Request $request)
    {
        $comment = new Comment();
        if ($request->get('comment_body')) {
            $comment->body = '@student: ' . $request->get('comment_body');
            $comment->user()->associate($request->user());
            $forum = Forum::find($request->get('post_id'));
            $forum->comment()->save($comment);
            return back();
        } else {
            return back()->with('fail', 'Comment field is empty');
        }
    }
    public function addForumCommentReply(Request $request)
    {
        $reply = new Comment();
        if ($request->get('comment_body')) {
            $reply->body = '@student: ' . $request->get('comment_body');
            $reply->user()->associate($request->user());
            $reply->ID_parent = $request->get('comment_id');
            $forum = Forum::find($request->get('post_id'));
            $forum->comment()->save($reply);
            return back();
        } else {
            return back()->with('fail', 'Comment field is empty');
        }
    }
    public function ForumDeleteComment(Comment $comment)
    {
        $comment->delete();
        return back();
    }
    public function back()
    {
        return redirect()->back();
    }
}
