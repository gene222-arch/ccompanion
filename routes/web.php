<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;

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

Route::get('/', [PageController::class, 'welcome']);

Auth::routes([
    'register' => false
]);

Route::middleware('auth')->group(function ()
{
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('announcements', AnnouncementController::class);
    Route::get('/enable/{announcement}', [AnnouncementController::class, 'toggleEnable'])->name('announcements.enabled');
    Route::resource('administrators', AdminController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('professors', ProfessorController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::post('/schedules/details/{schedule}', [ScheduleController::class, 'storeDetails'])->name('schedules.store.details');
    Route::resource('students', StudentController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('registrars', RegistrarController::class);
});
