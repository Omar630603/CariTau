<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\File;
use App\Models\Forum;
use App\Models\Major;
use App\Models\Material;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizUser;
use App\Models\Score;
use App\Models\Transaction;
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
        foreach ($userCourse as $course) {
            $this->UpdateStatus($course);
        }
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
        $banks = Bank::all();
        $transaction = Transaction::where('ID_user', '=', Auth::user()->ID_user)->where('ID_course', '=', $course->ID_course)->first();
        $enrollment = Enrollment::where('ID_user', '=', Auth::user()->ID_user)->where('ID_course', '=', $course->ID_course)->first();
        $major = Major::where('ID_major', '=', $course->ID_major)->first();
        $courses = Course::where('ID_major', '=', $course->ID_major)->get();
        $materials = Material::where('ID_course', '=', $course->ID_course)->orderBy('order', 'ASC')->get();
        return view('user.course', compact('enrollment', 'major', 'course', 'courses', 'materials', 'banks', 'transaction'));
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
            $quiz_user = QuizUser::where('ID_user', '=', Auth::user()->ID_user)->where('ID_quiz', '=', $quizzes->first()->ID_quiz)->first();
        } else {
            $questions = new Question;
            $quiz_user = new QuizUser;
        }
        return view('user.material', compact('enrollment', 'course', 'courses', 'materials', 'material', 'files', 'videos', 'quizzes', 'forums', 'questions', 'quiz_user'));
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
    public function showQuiz(Quiz $quiz, Course $course, Material $material)
    {
        $quiz_user = QuizUser::where('ID_user', '=', Auth::user()->ID_user)->where('ID_quiz', '=', $quiz->ID_quiz)->first();
        $materials = Material::where('ID_course', '=', $course->ID_course)->orderBy('order', 'ASC')->get();
        $enrollment = Enrollment::where('ID_user', '=', Auth::user()->ID_user)->where('ID_course', '=', $course->ID_course)->first();
        $courses = Course::where('ID_major', '=', $course->ID_major)->get();
        $questions = Question::where('ID_quiz', '=', $quiz->ID_quiz)->get();
        return view('user.showQuiz', compact('quiz', 'material', 'enrollment', 'course', 'courses', 'materials', 'questions', 'quiz_user'));
    }
    public function doQuiz(Request $request, Quiz $quiz)
    {
        $questions = Question::where('ID_quiz', '=', $quiz->ID_quiz)->get();
        $total = 0;
        foreach ($questions as $question) {
            $score = new Score;
            $score->ID_question = $question->ID_question;
            $score->ID_user = Auth::user()->ID_user;
            if ($question->correctAnswer === $request->get('answer' . $question->ID_question)) {
                $score->userAnswer = $request->get('answer' . $question->ID_question);
                $score->score = 100;
            } else {
                $score->userAnswer = $request->get('answer' . $question->ID_question);
                $score->score = 0;
            }
            $score->save();
            $total += $score->score;
        }
        $quiz_user = new QuizUser;
        $quiz_user->ID_user = Auth::user()->ID_user;
        $quiz_user->ID_quiz = $quiz->ID_quiz;
        $quiz_user->score = $total / count($questions);
        $quiz_user->save();
        $material = Material::where('ID_material', '=', $quiz->ID_material)->first();
        $course = Course::where('ID_course', '=', $material->ID_course)->first();
        $this->UpdateStatus($course);
        return redirect()->back();
    }
    public function UpdateStatus(Course $course)
    {
        $materials = Material::where('ID_course', '=', $course->ID_course)->get();
        $quiz_userS = QuizUser::where('ID_user', '=', Auth::user()->ID_user)->get();
        $totalQuiz = 0;
        $totalScore = 0;
        $totalMaterial = 0;
        foreach ($materials as $key) {
            $totalMaterial++;
            $quizS = Quiz::where('ID_material', '=', $key->ID_material)->first();
            if ($quizS) {
                foreach ($quiz_userS as $q) {
                    if ($q->ID_quiz == $quizS->ID_quiz) {
                        $totalQuiz++;
                        $totalScore += $q->score;
                    }
                }
            } else {
                $totalMaterial--;
            }
        }
        $enrollment = Enrollment::where('ID_user', '=', Auth::user()->ID_user)->where('ID_course', '=', $course->ID_course)->first();
        if ($totalScore <= 0) {
            $scoreE = 0;
        } else {
            $scoreE = ($totalScore / ($totalQuiz * 100)) * 100;
        }
        if ($totalQuiz <= 0) {
            $progress = 0;
        } else {
            $progress =  ($totalQuiz  / $totalMaterial) * 100;
        }
        $enrollment->score = $scoreE;
        $enrollment->progress = $progress;
        $enrollment->save();
    }
    public function payCourse(Request $request)
    {
        if ($request->get('ID_bank')) {
        } else {
            return redirect()->back()->with('fail', 'Select Bank');
        }
        if ($request->file('image')) {
            $image_name = $request->file('image')->store('transactions', 'public');
        } else {
            return redirect()->back()->with('fail', 'Somthing Wrong with the Image');
        }
        $transaction = new Transaction;
        $transaction->ID_user = Auth::user()->ID_user;
        $transaction->ID_course = $request->get('ID_course');
        $transaction->ID_bank = $request->get('ID_bank');
        $transaction->transaction = $request->get('transaction');
        $transaction->proof = $image_name;
        $transaction->save();
        return redirect()->back()->with('success', 'Your Transaction Has Been Sent Successfully. Please, wait for the approval process. Thank you!');
    }
}
