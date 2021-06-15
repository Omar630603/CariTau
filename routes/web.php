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

//guest//
Route::get('/', [GuestController::class, 'home'])->name('/');
Route::get('/abour-us', [GuestController::class, 'aboutUs'])->name('aboutUs');
Route::get('/courses', [GuestController::class, 'courses'])->name('courses');
Route::get('/lecturers', [GuestController::class, 'lecturers'])->name('lecturers');
Route::get('/contact-us', [GuestController::class, 'contactUs'])->name('contactUs');
Route::post('/contact-us/sendMessage', [GuestController::class, 'sendMessage'])->name('contactUsSendMessage');
Route::get('/login-first', [GuestController::class, 'redirectLogin'])->name('redirectLogin');
//home//
Route::get('/home', [HomeController::class, 'index'])->name('home');

//auth//
Auth::routes();

//StudentAccess//
Route::get('/user/home', [UserController::class, 'index'])->name('user.home')->middleware('StudentAccess');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile')->middleware('StudentAccess');
Route::get('/user/mycourse', [UserController::class, 'mycourse'])->name('user.mycourse')->middleware('StudentAccess');
Route::post('/user/profile/edit/{user}', [UserController::class, 'editStudent'])->name('userStudent.update')->middleware('StudentAccess');
Route::put('/user/profile/editImage/{user}', [UserController::class, 'editStudentImage'])->name('userStudent.updateImage')->middleware('StudentAccess');
Route::post('/user/profile/restoreImage/{user}', [UserController::class, 'editStudentImageDefult'])->name('userStudent.restoreImage')->middleware('StudentAccess');
Route::delete('/user/profile/delete/{user}', [UserController::class, 'deleteStudent'])->name('userStudent.delete')->middleware('StudentAccess');
Route::get('/user/course/{course}', [UserController::class, 'course'])->name('course')->middleware('StudentAccess');
Route::get('/user/course/enroll/{course}', [UserController::class, 'enroll'])->name('enroll')->middleware('StudentAccess');
Route::get('/user/course/Unenroll/{course}', [UserController::class, 'unenroll'])->name('Unenroll')->middleware('StudentAccess');
Route::get('/user/course/{course}/material/{material}', [UserController::class, 'material'])->name('material')->middleware('StudentAccess');
Route::get('/user/course/material/{file}/downloadFiles', [UserController::class, 'downloadFile'])->name('user.downloadFiles')->middleware('StudentAccess');
Route::get('/user/course/material/showFiles/{file}', [UserController::class, 'showFile'])->name('user.showFile')->middleware('StudentAccess');
Route::get('/back', [UserController::class, 'back'])->name('back')->middleware('StudentAccess');

Route::get('/user/course/{forum}/showForum/{course}/material/{material}', [UserController::class, 'showForum'])->name('user.showForum')->middleware('StudentAccess');
Route::post('/user/course/material/forum/addComment', [UserController::class, 'addForumComment'])->name('user.addForumComment')->middleware('StudentAccess');
Route::post('/user/course/material/forum/addComment/reply', [UserController::class, 'addForumCommentReply'])->name('user.addForumCommentReply')->middleware('StudentAccess');
Route::delete('/user/course/material/forum/{comment}/deleteComment', [UserController::class, 'ForumDeleteComment'])->name('user.deleteComment')->middleware('StudentAccess');

//AdminAccess//
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
Route::post('/admin/major/course/sortMaterials/{material}', [AdminController::class, 'SortMaterials'])->name('admin.SortMaterials')->middleware('AdminAccess');

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
Route::get('/admin/comments/{c}/publish', [AdminController::class, 'commentsAdminPublish'])->name('admin.commentsPublish')->middleware('AdminAccess');
Route::get('/admin/comments/{c}/unPublish', [AdminController::class, 'commentsAdminUnPublish'])->name('admin.commentsUnPublish')->middleware('AdminAccess');
Route::get('/admin/comments/{c}/delete', [AdminController::class, 'commentsAdminDelete'])->name('admin.commentsAdminDelete')->middleware('AdminAccess');
Route::get('/admin/comments/{c}/reply', [AdminController::class, 'replyEmail'])->name('admin.commentsAdminReply')->middleware('AdminAccess');

Route::get('/admin/others', [AdminController::class, 'othersAdmin'])->name('admin.others')->middleware('AdminAccess');

//LecturerAccess//
Route::get('/lecturer/home', [LecturerController::class, 'index'])->name('lecturer.home')->middleware('LecturerAccess');

Route::get('/lecturer/profile', [LecturerController::class, 'profile'])->name('lecturer.profile')->middleware('LecturerAccess');
Route::post('/lecturer/profile/edit/{user}', [LecturerController::class, 'editLecturer'])->name('userLecturer.update')->middleware('LecturerAccess');
Route::put('/lecturer/profile/editImage/{user}', [LecturerController::class, 'editLecturerImage'])->name('userLecturer.updateImage')->middleware('LecturerAccess');
Route::post('/lecturer/profile/restoreImage/{user}', [LecturerController::class, 'editLecturerImageDefult'])->name('userLecturer.restoreImage')->middleware('LecturerAccess');
Route::delete('/lecturer/profile/delete/{user}', [LecturerController::class, 'deleteLecturer'])->name('userLecturer.delete')->middleware('LecturerAccess');

Route::get('/lecturer/course', [LecturerController::class, 'course'])->name('lecturer.mycourse')->middleware('LecturerAccess');
Route::post('/lecturer/course/edit/{course}', [LecturerController::class, 'editCourse'])->name('courseLecturer.update')->middleware('LecturerAccess');
Route::put('/lecturer/course/editImage/{course}', [LecturerController::class, 'editCourseImage'])->name('courseLecturer.updateImage')->middleware('LecturerAccess');
Route::post('/lecturer/course/restoreImage/{course}', [LecturerController::class, 'editCourseImageDefult'])->name('courseLecturer.restoreImage')->middleware('LecturerAccess');
Route::post('/lecturer/course/add/material/{course}', [LecturerController::class, 'addMaterialCourseLecturer'])->name('lecturer.courseAddMaterial')->middleware('LecturerAccess');
Route::post('/lecturer/course/sortMaterials/{material}', [LecturerController::class, 'SortMaterials'])->name('lecturer.SortMaterials')->middleware('LecturerAccess');

Route::get('/lecturer/course/material/{material}', [LecturerController::class, 'showMaterial'])->name('lecturer.materialDetails')->middleware('LecturerAccess');
Route::post('/lecturer/course/material/edit/{material}', [LecturerController::class, 'editMaterial'])->name('materialLecturer.update')->middleware('LecturerAccess');
Route::put('/lecturer/course/material/editImage/{material}', [LecturerController::class, 'editMaterialImage'])->name('materialLecturer.updateImage')->middleware('LecturerAccess');
Route::post('/lecturer/course/material/restoreImage/{material}', [LecturerController::class, 'editMaterialImageDefult'])->name('materialLecturer.restoreImage')->middleware('LecturerAccess');
Route::delete('/lecturer/course/material/delete/{material}', [LecturerController::class, 'deleteMaterial'])->name('materialLecturer.delete')->middleware('LecturerAccess');

Route::post('/lecturer/course/material/{material}/uploadFiles', [LecturerController::class, 'materialUploadFiles'])->name('lecturer.uploadFiles')->middleware('LecturerAccess');
Route::post('/lecturer/course/material/{file}/editFiles', [LecturerController::class, 'editFile'])->name('lecturer.editFiles')->middleware('LecturerAccess');
Route::delete('/lecturer/course/material/{file}/deleteFiles', [LecturerController::class, 'deleteFile'])->name('lecturer.deleteFiles')->middleware('LecturerAccess');
Route::get('/lecturer/course/material/{file}/downloadFiles', [LecturerController::class, 'downloadFile'])->name('lecturer.downloadFiles')->middleware('LecturerAccess');
Route::get('/lecturer/course/material/showFiles/{file}', [LecturerController::class, 'showFile'])->name('lecturer.showFile')->middleware('LecturerAccess');

Route::post('/lecturer/course/material/{material}/addVideos', [LecturerController::class, 'materialAddVideos'])->name('lecturer.addVideos')->middleware('LecturerAccess');
Route::post('/lecturer/course/material/{video}/editVideos', [LecturerController::class, 'editVideo'])->name('lecturer.editVideos')->middleware('LecturerAccess');
Route::delete('/lecturer/course/material/{video}/deleteVideos', [LecturerController::class, 'deleteVideo'])->name('lecturer.deleteVideos')->middleware('LecturerAccess');

Route::post('/lecturer/course/material/{material}/addQuiz', [LecturerController::class, 'materialAddQuiz'])->name('lecturer.addQuiz')->middleware('LecturerAccess');
Route::post('/lecturer/course/material/{quiz}/editQuiz', [LecturerController::class, 'editQuiz'])->name('lecturer.editQuiz')->middleware('LecturerAccess');
Route::delete('/lecturer/course/material/{quiz}/deleteQuiz', [LecturerController::class, 'deleteQuiz'])->name('lecturer.deleteQuiz')->middleware('LecturerAccess');
Route::get('/lecturer/course/material/{quiz}/{material}/addQuestion', [LecturerController::class, 'addQuestion'])->name('lecturer.addQuestion')->middleware('LecturerAccess');
Route::post('/lecturer/course/material/{quiz}/postQuestion', [LecturerController::class, 'postQuestion'])->name('lecturer.postQuestion')->middleware('LecturerAccess');
Route::post('/lecturer/course/material/editQuestion/{Question}', [LecturerController::class, 'editQuestion'])->name('lecturer.editQuestion')->middleware('LecturerAccess');
Route::delete('/lecturer/course/material/deleteQuestion/{Question}', [LecturerController::class, 'deleteQuestion'])->name('lecturer.deleteQuestion')->middleware('LecturerAccess');

Route::post('/lecturer/course/material/{material}/addForum', [LecturerController::class, 'materialAddForum'])->name('lecturer.addForum')->middleware('LecturerAccess');
Route::post('/lecturer/course/material/{forum}/editForum', [LecturerController::class, 'editForum'])->name('lecturer.editForum')->middleware('LecturerAccess');
Route::delete('/lecturer/course/material/{forum}/deleteForum', [LecturerController::class, 'deleteForum'])->name('lecturer.deleteForum')->middleware('LecturerAccess');
Route::get('/lecturer/course/material/{forum}/showForum', [LecturerController::class, 'showForum'])->name('lecturer.showForum')->middleware('LecturerAccess');
Route::post('/lecturer/course/material/forum/addComment', [LecturerController::class, 'addForumComment'])->name('lecturer.addForumComment')->middleware('LecturerAccess');
Route::post('/lecturer/course/material/forum/addComment/reply', [LecturerController::class, 'addForumCommentReply'])->name('lecturer.addForumCommentReply')->middleware('LecturerAccess');
Route::delete('/lecturer/course/material/forum/{comment}/deleteComment', [LecturerController::class, 'ForumDeleteComment'])->name('lecturer.deleteComment')->middleware('LecturerAccess');
