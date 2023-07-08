<?php

use App\Http\Controllers\Admin\BallsController;
use App\Http\Controllers\Admin\BootsController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\FieldsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\User\ScheduleController as UserScheduleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentCallbackController;

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

    // admin
    Route::get('admin/schedules', [AdminScheduleController::class, 'mySchedules'])->name('admin.schedules');
    Route::delete('admin/schedules/delete/{id}', [AdminScheduleController::class, 'destroy'])->name('admin.schedules.delete');
    Route::post('/admin/schedules/store', [AdminScheduleController::class, 'store'])->name('admin.schedule.store');
    Route::get('/admin/data', [AdminScheduleController::class, 'data']);
    Route::get('/admin/detail/{prefix}', [AdminScheduleController::class, 'detail'])->name('admin.detail');
    Route::get('/admin/fields', [FieldsController::class, 'index'])->name('admin.fields');
    Route::post('/admin/store', [FieldsController::class, 'store'])->name('admin.store.fields');
    Route::get('/admin/data/fields', [FieldsController::class, 'data']);
    Route::get('/admin/fields/edit/{id}', [FieldsController::class, 'edit'])->name('admin.edit.fields');
    Route::put('/admin/fields/update/{id}', [FieldsController::class, 'update'])->name('admin.update.fields');
    Route::delete('/admin/fields/delete/{id}', [FieldsController::class, 'destroy'])->name('admin.delete.fields');
    Route::get('admin/booking', [AdminScheduleController::class, 'index'])->name('admin.booking');
    Route::get('admin/boots', [BootsController::class, 'index'])->name('admin.boots');
    Route::post('admin/boots/store', [BootsController::class, 'store'])->name('admin.boots.store');
    Route::get('admin/boots/edit/{id}', [BootsController::class, 'edit'])->name('admin.boots.edit');
    Route::put('admin/boots/update/{id}', [BootsController::class, 'update'])->name('admin.boots.update');
    Route::delete('admin/boots/delete/{id}', [BootsController::class, 'destroy'])->name('admin.boots.destroy');
    Route::get('admin/balls', [BallsController::class, 'index'])->name('admin.balls');
    Route::post('admin/balls/store', [BallsController::class, 'store'])->name('admin.balls.store');
    Route::get('admin/balls/edit/{id}', [BallsController::class, 'edit'])->name('admin.balls.edit');
    Route::put('admin/balls/update/{id}', [BallsController::class, 'update'])->name('admin.balls.update');
    Route::delete('admin/balls/delete/{id}', [BallsController::class, 'destroy'])->name('admin.balls.destroy');


    // Route::resource('boots', BootsController::class);

    // user
    Route::get('user/schedules', [UserScheduleController::class, 'index'])->name('user.schedules');
    Route::get('user/my-schedules', [UserScheduleController::class, 'mySchedules'])->name('user.my-schedules');
    Route::delete('/user/my-schedules/delete/{id}', [UserScheduleController::class, 'destroy'])->name('user.schedules.delete');
    Route::put('/user/schedules/edit', [UserScheduleController::class, 'edit'])->name('user.schedules.edit');
    Route::get('/user/data', [UserScheduleController::class, 'data']);
    Route::post('user/store', [UserScheduleController::class, 'store'])->name('user.schedules.store');
    Route::get('/user/detail/{prefix}', [UserScheduleController::class, 'detail'])->name('user.schedules.detail');
});

Route::get('/user/get-data-boots/{id}', [UserScheduleController::class, 'getBoots'])->name('get-data-boots');
Route::get('/user/get-data-balls/{id}', [UserScheduleController::class, 'getBalls'])->name('get-data-balls');
Route::get('/admin/get-data-boots/{id}', [UserScheduleController::class, 'getBoots'])->name('get-data-boots');
Route::get('/admin/get-data-balls/{id}', [UserScheduleController::class, 'getBalls'])->name('get-data-balls');

// payment
Route::post('payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);

Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules');
