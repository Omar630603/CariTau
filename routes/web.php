<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/user/home', [App\Http\Controllers\UserController::class, 'index'])->name('user.home');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home')->middleware('AdminAccess');
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'authAdmin'])->name('admin.auth')->middleware('AdminAccess');
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboardAdmin'])->name('admin.dashboard')->middleware('AdminAccess');
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'usersAdmin'])->name('admin.users')->middleware('AdminAccess');
Route::get('/admin/lecturers', [App\Http\Controllers\AdminController::class, 'lecturesAdmin'])->name('admin.lecturers')->middleware('AdminAccess');
Route::get('/admin/majors', [App\Http\Controllers\AdminController::class, 'majorsAdmin'])->name('admin.majors')->middleware('AdminAccess');
Route::get('/admin/comments', [App\Http\Controllers\AdminController::class, 'commentsAdmin'])->name('admin.comments')->middleware('AdminAccess');
Route::get('/admin/others', [App\Http\Controllers\AdminController::class, 'othersAdmin'])->name('admin.others')->middleware('AdminAccess');


Route::get('/lecturer/home', [App\Http\Controllers\LecturerController::class, 'index'])->name('lecturer.home')->middleware('LecturerAccess');
