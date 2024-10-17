<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\UserController;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

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


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::get('/attendance', [AttendanceController::class, 'dailyAttendance']);
    Route::post('/punchin', [AttendanceController::class, 'punchIn']);
    Route::post('/punchout', [AttendanceController::class, 'punchOut']);
    Route::post('/breakin', [AttendanceController::class, 'breakIn']);
    Route::post('/breakout', [AttendanceController::class, 'breakOut']);
    Route::delete('/delete', [AttendanceController::class, 'destroy']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/user_attendance', [AttendanceController::class, 'userAttendance']);
    Route::match(['get', 'post'], '/users/search', [UserController::class, 'search']);
});
