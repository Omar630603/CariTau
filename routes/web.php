<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LecturerController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user/home', [UserController::class, 'index'])->name('user.home');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.home')->middleware('AdminAccess');
Route::post('/admin', [AdminController::class, 'authAdmin'])->name('admin.auth')->middleware('AdminAccess');
Route::get('/admin/dashboard', [AdminController::class, 'dashboardAdmin'])->name('admin.dashboard')->middleware('AdminAccess');
Route::get('/admin/users', [AdminController::class, 'usersAdmin'])->name('admin.users')->middleware('AdminAccess');
Route::post('/admin/student', [AdminController::class, 'registerUserAdmin'])->name('register.userAdmin')->middleware('AdminAccess');
Route::post('/admin/lecturer', [AdminController::class, 'registerLecturerAdmin'])->name('register.lecturerAdmin')->middleware('AdminAccess');
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


Route::get('/admin/lecturers', [AdminController::class, 'lecturesAdmin'])->name('admin.lecturers')->middleware('AdminAccess');
Route::get('/admin/majors', [AdminController::class, 'majorsAdmin'])->name('admin.majors')->middleware('AdminAccess');
Route::get('/admin/comments', [AdminController::class, 'commentsAdmin'])->name('admin.comments')->middleware('AdminAccess');
Route::get('/admin/others', [AdminController::class, 'othersAdmin'])->name('admin.others')->middleware('AdminAccess');


Route::get('/lecturer/home', [LecturerController::class, 'index'])->name('lecturer.home')->middleware('LecturerAccess');
