<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\User\ScheduleController as UserScheduleController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // user
    Route::get('user/schedules', [UserScheduleController::class, 'index'])->name('user.schedules');
    Route::get('user/my-schedules', [UserScheduleController::class, 'mySchedules'])->name('user.my-schedules');
    Route::delete('/user/my-schedules/delete', [UserScheduleController::class, 'destroy'])->name('user.schedules.delete');
    Route::put('/user/schedules/edit', [UserScheduleController::class, 'edit'])->name('user.schedules.edit');
    Route::get('/user/data', [UserScheduleController::class, 'data']);
    Route::post('user/store', [UserScheduleController::class, 'store'])->name('user.schedules.store');
});

Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules');
