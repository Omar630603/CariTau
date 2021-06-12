<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\File;
use App\Models\Forum;
use App\Models\Lecturer;
use App\Models\Major;
use App\Models\Material;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lecturer.index');
    }
    public function profile()
    {
        return view('lecturer.profile');
    }

    public function course()
    {
        $lecturer = User::where('ID_user', '=', Auth::user()->ID_user)->with('lecturer')->get();
        $lecturer = $lecturer[0];
        $course = Course::where('ID_course', '=', $lecturer->lecturer->ID_course)->get();
        $course = $course[0];
        $majors = Major::all();
        $materials = Material::where('ID_course', '=', $course->ID_course)->orderBy('order', 'ASC')->get();
        return view('lecturer.course', compact('course', 'lecturer', 'materials', 'majors'));
    }
    public function editCourse(Request $request, Course $course)
    {
        $request->validate([
            'course_name' => 'required',
        ]);
        $course->course_name = $request->get('course_name');
        if ($request->get('description')) {
            $course->description = $request->get('description');
        }
        $course->save();
        return redirect()->back();
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
        return redirect()->back();
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
        return redirect()->back();
    }
    public function addMaterialCourseLecturer(Request $request, Course $course)
    {
        $materials = Material::where('ID_course', '=', $course->ID_course)->orderBy('order', 'ASC')->get();
        $order = 0;
        foreach ($materials as $key) {
            $order = $key->order;
        }
        try {
            $request->validate([
                'material_name' => 'required',
                'description' => 'required',
            ]);
            $material = new Material;
            $material->course()->associate($course);
            $material->material_name = $request->get('material_name');
            $material->description = $request->get('description');
            $material->order = $order + 1;
            $material->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->back()->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function SortMaterials(Request $request, Material $material)
    {
        $materials = Material::where('ID_course', '=', $material->ID_course)->orderBy('order', 'ASC')->get();
        foreach ($materials as $key) {
            if ($key->ID_material == $request->get('ID_material' . $key->ID_material)) {
                $key->order = $request->get('order' . $key->ID_material);
                $key->save();
            }
        }
        return redirect()->back();
    }
    public function showMaterial(Material $material)
    {
        $courses = Course::all();
        $course = Course::where('ID_course', '=', $material->ID_course)->first();
        $lecturer = User::where('ID_user', '=', Auth::user()->ID_user)->with('lecturer')->get();
        $lecturer = $lecturer[0];
        $files = File::where('ID_material', '=', $material->ID_material)->get();
        $videos = Video::where('ID_material', '=', $material->ID_material)->get();
        $quizzes = Quiz::where('ID_material', '=', $material->ID_material)->get();
        $forums = Forum::where('ID_material', '=', $material->ID_material)->get();
        if ($quizzes->first()) {
            $questions = Question::where('ID_quiz', '=', $quizzes->first()->ID_quiz)->get();
        } else {
            $questions = new Question;
        }

        return view('lecturer.materialEdit', compact('material', 'lecturer', 'courses', 'files', 'videos', 'quizzes', 'questions', 'forums'));
    }
    public function editMaterial(Request $request, Material $material)
    {

        $request->validate([
            'material_name' => 'required',
        ]);
        $material->material_name = $request->get('material_name');
        if ($request->get('description')) {
            $material->description = $request->get('description');
        }
        $material->save();
        return redirect()->back();
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
        return redirect()->back();
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
        return redirect()->back();
    }
    public function deleteMaterial(Material $material)
    {
        if ($material->image == "Material_images/default.png") {
            $material->delete();
        } else {
            Storage::delete('public/' . $material->image);
            $material->delete();
        }
        return redirect()->route('lecturer.mycourse');
    }
    public function materialUploadFiles(Request $request, Material $material)
    {
        $files = $request->file('files');
        if ($request->hasFile('files')) {
            foreach ($files as $fileB) {
                $file = new File;
                $file->material()->associate($material);
                $file->file_title = pathinfo($fileB->getClientOriginalName(), PATHINFO_FILENAME);
                $type = $this->Typefile($fileB->getClientOriginalExtension());
                switch ($type) {
                    case 'pdf':
                        $file->icon = 'images/pdf.png';
                        break;
                    case 'word':
                        $file->icon = 'images/word.png';
                        break;
                    case 'powerpoint':
                        $file->icon = 'images/powerpoint.png';
                        break;
                    case 'excel':
                        $file->icon = 'images/excel.png';
                        break;
                    case 'archive':
                        $file->icon = 'images/archive.png';
                        break;
                    case 'image':
                        $file->icon = 'images/image.png';
                        break;
                    default:
                        $file->icon = 'images/alt.png';
                }
                $file->file_name = $fileB->store('Material_files', 'public');
                $file->file_extension = $fileB->getClientOriginalExtension();
                $file->save();
            }
        }
        $message = 'Added Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function Typefile($extension)
    {
        switch ($extension) {
            case 'pdf':
                $type = 'pdf';
                break;
            case 'docx':
            case 'doc':
                $type = 'word';
                break;
            case 'ppt':
            case 'pptx':
                $type = 'powerpoint';
                break;
            case 'xls':
            case 'xlsx':
            case 'csv':
                $type = 'excel';
                break;
            case 'zip':
            case '7z':
            case 'rar':
                $type = 'archive';
                break;
            case 'jpg':
            case 'jpeg':
            case 'png':
                $type = 'image';
                break;
            default:
                $type = 'alt';
        }
        return $type;
    }
    public function editFile(Request $request, File $file)
    {
        $request->validate([
            'file_title' => 'required',
        ]);
        $file->file_title = $request->get('file_title');
        if ($request->get('description')) {
            $file->description = $request->get('description');
        }
        $file->save();
        return redirect()->back()->with('success', 'Edited!');
    }
    public function deletefile(File $file)
    {
        Storage::delete('public/' . $file->file_name);
        $file->delete();
        return redirect()->back()->with('success', 'Deleted!');
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
    public function materialAddVideos(Request $request, Material $material)
    {
        try {
            $request->validate([
                'video_name' => 'required',
                'video_url' => 'required',
            ]);
            $video = new Video;
            $video->material()->associate($material);
            $video->video_name = $request->get('video_name');
            $video->description = $request->get('description');
            $video->video_url = $request->get('video_url');
            $video->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->back()->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editVideo(Request $request, Video $video)
    {
        $request->validate([
            'video_name' => 'required',
            'video_url' => 'required',
        ]);
        $video->video_name = $request->get('video_name');
        if ($request->get('description')) {
            $video->description = $request->get('description');
        }
        $video->video_url = $request->get('video_url');
        $video->save();
        return redirect()->back()->with('success', 'Edited!');
    }
    public function deleteVideo(Video $video)
    {
        $video->delete();
        return redirect()->back()->with('success', 'Deleted!');
    }
    public function materialAddQuiz(Request $request, Material $material)
    {
        try {
            $request->validate([
                'quiz_name' => 'required',
            ]);
            $quiz = new Quiz;
            $quiz->material()->associate($material);
            $quiz->quiz_name = $request->get('quiz_name');
            $quiz->description = $request->get('description');
            $quiz->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->back()->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editQuiz(Request $request, Quiz $quiz)
    {
        $request->validate([
            'quiz_name' => 'required',
        ]);
        $quiz->quiz_name = $request->get('quiz_name');
        if ($request->get('description')) {
            $quiz->description = $request->get('description');
        }
        $quiz->save();
        return redirect()->back()->with('success', 'Edited!');
    }
    public function deleteQuiz(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->back()->with('success', 'Deleted!');
    }
    public function addQuestion(Quiz $quiz, Material $material)
    {
        $questions = Question::where('ID_quiz', '=', $quiz->ID_quiz)->get();
        return view('lecturer.addQuestion', compact('quiz', 'material', 'questions'));
    }
    public function materialAddForum(Request $request, Material $material)
    {
        try {
            $request->validate([
                'title' => 'required',
                'body' => 'required',
            ]);
            $forum = new Forum;
            $forum->material()->associate($material);
            $forum->title = '@lecturer: ' . $request->get('title');
            $forum->body = $request->get('body');
            $forum->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->back()->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editForum(Request $request, Forum $forum)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $forum->title = $request->get('title');
        if ($request->get('body')) {
            $forum->body = $request->get('body');
        }
        $forum->save();
        return redirect()->back()->with('success', 'Edited!');
    }
    public function deleteForum(Forum $forum, Material $material)
    {
        $forum->delete();
        return redirect()->back()->with('success', 'Deleted!');
    }
    public function showForum(Forum $forum)
    {
        $material = Material::where('ID_material', $forum->ID_material)->first();
        return view('lecturer.showForum', compact('forum', 'material'));
    }
    public function addForumComment(Request $request)
    {
        $comment = new Comment();
        if ($request->get('comment_body')) {
            $comment->body = '@lecturer: ' . $request->get('comment_body');
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
            $reply->body = '@lecturer: ' . $request->get('comment_body');
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
    public function postQuestion(Request $request, Quiz $quiz)
    {
        try {
            $request->validate([
                'question' => 'required',
                'option_one' => 'required',
                'option_two' => 'required',
                'option_three' => 'required',
                'option_four' => 'required',
                'correctAnswer' => 'required',
            ]);
            $question = new Question;
            $question->quiz()->associate($quiz);
            $question->question = $request->get('question');
            $question->option_one = $request->get('option_one');
            $question->option_two = $request->get('option_two');
            $question->option_three = $request->get('option_three');
            $question->option_four = $request->get('option_four');
            $question->correctAnswer = $request->get('correctAnswer');
            $question->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->back()->with('fail', $message);
        }
        $message = 'Added Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editQuestion(Request $request, $question)
    {
        $question = Question::find($question);
        try {
            $request->validate([
                'question' . $question->ID_question => 'required',
                'option_one' . $question->ID_question => 'required',
                'option_two' . $question->ID_question => 'required',
                'option_three' . $question->ID_question => 'required',
                'option_four' . $question->ID_question => 'required',
                'correctAnswer' . $question->ID_question => 'required',
            ]);
            $question->question = $request->get('question' . $question->ID_question);
            $question->option_one = $request->get('option_one' . $question->ID_question);
            $question->option_two = $request->get('option_two' . $question->ID_question);
            $question->option_three = $request->get('option_three' . $question->ID_question);
            $question->option_four = $request->get('option_four' . $question->ID_question);
            $question->correctAnswer = $request->get('correctAnswer' . $question->ID_question);
            $question->save();
        } catch (Exception  $e) {
            $message = 'There was Something Wrong. Please, Try again';
            return redirect()->back()->with('fail', $message);
        }
        $message = 'Updated Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function deleteQuestion($question)
    {
        $question = Question::find($question);
        $question->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }
    public function editLecturer(Request $request, User $user)
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
    public function editLecturerImage(Request $request, User $user)
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
    public function editLecturerImageDefult(User $user)
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
    public function deleteLecturer(User $user)
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
