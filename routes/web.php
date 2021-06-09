<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [GuestController::class, 'home'])->name('/');
Route::get('/abour-us', [GuestController::class, 'aboutUs'])->name('aboutUs');
Route::get('/courses', [GuestController::class, 'courses'])->name('courses');
Route::get('/lecturers', [GuestController::class, 'lecturers'])->name('lecturers');
Route::get('/contact-us', [GuestController::class, 'contactUs'])->name('contactUs');

Route::get('/home', [HomeController::class, 'index'])->name('home');


Auth::routes();

Route::get('/user/home', [UserController::class, 'index'])->name('user.home')->middleware('StudentAccess');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.home')->middleware('AdminAccess');
Route::post('/admin', [AdminController::class, 'authAdmin'])->name('admin.auth')->middleware('AdminAccess');
Route::get('/admin/dashboard', [AdminController::class, 'dashboardAdmin'])->name('admin.dashboard')->middleware('AdminAccess');
Route::get('/admin/users', [AdminController::class, 'usersAdmin'])->name('admin.users')->middleware('AdminAccess');
Route::post('/admin/student', [AdminController::class, 'registerUserAdmin'])->name('register.userAdmin')->middleware('AdminAccess');
Route::post('/admin/lecturer', [AdminController::class, 'registerLecturerAdmin'])->name('register.lecturerAdmin')->middleware('AdminAccess');
Route::get('/admin/Lecturers', [AdminController::class, 'lecturesAdmin'])->name('admin.lecturers')->middleware('AdminAccess');
Route::post('/admin/admin', [AdminController::class, 'registerAdminAdmin'])->name('register.adminAdmin')->middleware('AdminAccess');
Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search')->middleware('AdminAccess');
Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.userDetails')->middleware('AdminAccess');
Route::post('/admin/users/edit/{user}', [AdminController::class, 'editUser'])->name('userAdmin.update')->middleware('AdminAccess');
Route::put('/admin/users/editImage/{user}', [AdminController::class, 'editUserImage'])->name('userAdmin.updateImage')->middleware('AdminAccess');
Route::post('/admin/users/restoreImage/{user}', [AdminController::class, 'editUserImageDefult'])->name('userAdmin.restoreImage')->middleware('AdminAccess');
Route::delete('/admin/users/delete/{user}', [AdminController::class, 'deleteUser'])->name('userAdmin.delete')->middleware('AdminAccess');
Route::post('/admin/users/addCourse/{user}', [AdminController::class, 'addCourseUser'])->name('userAdmin.addStudentCourse')->middleware('AdminAccess');
Route::delete('/admin/users/deleteCourse/{user}/{Course}', [AdminController::class, 'deleteCourseUser'])->name('userAdmin.deleteStudentCourse')->middleware('AdminAccess');
Route::put('/admin/users/editCourse/{user}/{course}', [AdminController::class, 'editCourseUser'])->name('userAdmin.editStudentCourse')->middleware('AdminAccess');

Route::get('/admin/majors', [AdminController::class, 'majorsAdmin'])->name('admin.majors')->middleware('AdminAccess');
Route::get('/admin/majors/noCourse', [AdminController::class, 'noCourseMajorsAdmin'])->name('admin.noCourse')->middleware('AdminAccess');
Route::get('/admin/major/{major}', [AdminController::class, 'majorAdmin'])->name('admin.major')->middleware('AdminAccess');
Route::post('/admin/major/add', [AdminController::class, 'addMajorAdmin'])->name('admin.majorAdd')->middleware('AdminAccess');
Route::put('/admin/major/editImage/{major}', [AdminController::class, 'editMajorImage'])->name('majorAdmin.updateImage')->middleware('AdminAccess');
Route::post('/admin/major/restoreImage/{major}', [AdminController::class, 'editMajorImageDefult'])->name('majorAdmin.restoreImage')->middleware('AdminAccess');
Route::post('/admin/major/edit/{major}', [AdminController::class, 'editMajor'])->name('majorAdmin.update')->middleware('AdminAccess');
Route::delete('/admin/major/delete/{major}', [AdminController::class, 'deleteMajor'])->name('majorAdmin.delete')->middleware('AdminAccess');
Route::post('/admin/major/add/course/{major}', [AdminController::class, 'addMajorCourseAdmin'])->name('admin.majorAddCourse')->middleware('AdminAccess');

Route::get('/admin/major/course/{course}', [AdminController::class, 'showCourse'])->name('admin.courseDetails')->middleware('AdminAccess');
Route::put('/admin/major/course/editImage/{course}', [AdminController::class, 'editCourseImage'])->name('courseAdmin.updateImage')->middleware('AdminAccess');
Route::post('/admin/major/course/restoreImage/{course}', [AdminController::class, 'editCourseImageDefult'])->name('courseAdmin.restoreImage')->middleware('AdminAccess');
Route::post('/admin/major/course/edit/{course}', [AdminController::class, 'editCourse'])->name('courseAdmin.update')->middleware('AdminAccess');
Route::delete('/admin/major/course/delete/{course}/{major}', [AdminController::class, 'deleteCourse'])->name('courseAdmin.delete')->middleware('AdminAccess');
Route::post('/admin/major/add/course/material/{course}', [AdminController::class, 'addMaterialCourseAdmin'])->name('admin.courseAddMaterial')->middleware('AdminAccess');

Route::get('/admin/major/course/material/{material}', [AdminController::class, 'showMaterial'])->name('admin.materialDetails')->middleware('AdminAccess');
Route::put('/admin/major/course/material/editImage/{material}', [AdminController::class, 'editMaterialImage'])->name('materialAdmin.updateImage')->middleware('AdminAccess');
Route::post('/admin/major/course/material/restoreImage/{material}', [AdminController::class, 'editMaterialImageDefult'])->name('materialAdmin.restoreImage')->middleware('AdminAccess');
Route::post('/admin/major/course/material/edit/{material}', [AdminController::class, 'editMaterial'])->name('materialAdmin.update')->middleware('AdminAccess');
Route::delete('/admin/major/course/material/delete/{material}/{course}', [AdminController::class, 'deleteMaterial'])->name('materialAdmin.delete')->middleware('AdminAccess');

Route::post('/admin/major/course/material/{material}/uploadFiles', [AdminController::class, 'materialUploadFiles'])->name('admin.uploadFiles')->middleware('AdminAccess');
Route::post('/admin/major/course/material/{file}/{material}/editFiles', [AdminController::class, 'editFile'])->name('admin.editFiles')->middleware('AdminAccess');
Route::delete('/admin/major/course/material/{file}/{material}/deleteFiles', [AdminController::class, 'deleteFile'])->name('admin.deleteFiles')->middleware('AdminAccess');
Route::get('/admin/major/course/material/{file}/downloadFiles', [AdminController::class, 'downloadFile'])->name('admin.downloadFiles')->middleware('AdminAccess');
Route::get('/admin/major/course/material/showFiles/{file}', [AdminController::class, 'showFile'])->name('admin.showFile')->middleware('AdminAccess');

Route::post('/admin/major/course/material/{material}/addVideos', [AdminController::class, 'materialAddVideos'])->name('admin.addVideos')->middleware('AdminAccess');
Route::post('/admin/major/course/material/{video}/{material}/editVideos', [AdminController::class, 'editVideo'])->name('admin.editVideos')->middleware('AdminAccess');
Route::delete('/admin/major/course/material/{video}/{material}/deleteVideos', [AdminController::class, 'deleteVideo'])->name('admin.deleteVideos')->middleware('AdminAccess');

Route::post('/admin/major/course/material/{material}/addQuiz', [AdminController::class, 'materialAddQuiz'])->name('admin.addQuiz')->middleware('AdminAccess');
Route::post('/admin/major/course/material/{quiz}/{material}/editQuiz', [AdminController::class, 'editQuiz'])->name('admin.editQuiz')->middleware('AdminAccess');
Route::delete('/admin/major/course/material/{quiz}/{material}/deleteQuiz', [AdminController::class, 'deleteQuiz'])->name('admin.deleteQuiz')->middleware('AdminAccess');
Route::get('/admin/major/course/material/{quiz}/{material}/addQuestion', [AdminController::class, 'addQuestion'])->name('admin.addQuestion')->middleware('AdminAccess');
Route::post('/admin/major/course/material/{quiz}/postQuestion', [AdminController::class, 'postQuestion'])->name('admin.postQuestion')->middleware('AdminAccess');
Route::post('/admin/major/course/material/editQuestion/{Question}', [AdminController::class, 'editQuestion'])->name('admin.editQuestion')->middleware('AdminAccess');
Route::delete('/admin/major/course/material/deleteQuestion/{Question}', [AdminController::class, 'deleteQuestion'])->name('admin.deleteQuestion')->middleware('AdminAccess');

Route::post('/admin/major/course/material/{material}/addForum', [AdminController::class, 'materialAddForum'])->name('admin.addForum')->middleware('AdminAccess');
Route::post('/admin/major/course/material/{forum}/{material}/editForum', [AdminController::class, 'editForum'])->name('admin.editForum')->middleware('AdminAccess');
Route::delete('/admin/major/course/material/{forum}/{material}/deleteForum', [AdminController::class, 'deleteForum'])->name('admin.deleteForum')->middleware('AdminAccess');
Route::get('/admin/major/course/material/{forum}/showForum', [AdminController::class, 'showForum'])->name('admin.showForum')->middleware('AdminAccess');
Route::post('/admin/major/course/material/forum/addComment', [AdminController::class, 'addForumComment'])->name('admin.addForumComment')->middleware('AdminAccess');
Route::post('/admin/major/course/material/forum/addComment/reply', [AdminController::class, 'addForumCommentReply'])->name('admin.addForumCommentReply')->middleware('AdminAccess');
Route::delete('/admin/major/course/material/forum/{comment}/deleteComment', [AdminController::class, 'ForumDeleteComment'])->name('admin.deleteComment')->middleware('AdminAccess');

Route::get('/admin/comments', [AdminController::class, 'commentsAdmin'])->name('admin.comments')->middleware('AdminAccess');
Route::get('/admin/others', [AdminController::class, 'othersAdmin'])->name('admin.others')->middleware('AdminAccess');


Route::get('/lecturer/home', [LecturerController::class, 'index'])->name('lecturer.home')->middleware('LecturerAccess');
