<?php

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
    Route::get('/admin/data', [AdminScheduleController::class, 'data']);
    Route::get('/admin/edit/{prefix}', [AdminScheduleController::class, 'edit'])->name('admin.edit');
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

    // Route::resource('boots', BootsController::class);

    // user
    Route::get('user/schedules', [UserScheduleController::class, 'index'])->name('user.schedules');
    Route::get('user/my-schedules', [UserScheduleController::class, 'mySchedules'])->name('user.my-schedules');
    Route::delete('/user/my-schedules/delete', [UserScheduleController::class, 'destroy'])->name('user.schedules.delete');
    Route::put('/user/schedules/edit', [UserScheduleController::class, 'edit'])->name('user.schedules.edit');
    Route::get('/user/data', [UserScheduleController::class, 'data']);
    Route::post('user/store', [UserScheduleController::class, 'store'])->name('user.schedules.store');
    Route::get('/user/detail/{prefix}', [UserScheduleController::class, 'detail'])->name('user.schedules.detail');
});

Route::get('/user/get-data-boots/{id}', [UserScheduleController::class, 'getBoots'])->name('get-data-boots');

// payment
Route::post('payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);

Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules');
