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
Route::get('/admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home')->middleware('AdminAccess');
Route::get('/lecturer/home', [App\Http\Controllers\LecturerController::class, 'index'])->name('lecturer.home')->middleware('LecturerAccess');
