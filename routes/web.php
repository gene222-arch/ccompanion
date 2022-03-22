<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\ExportController;

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
    Route::get('/audit-trails', AuditTrailController::class)->name('audit.trails.index');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('announcements', AnnouncementController::class);
    Route::get('/enable/{announcement}', [AnnouncementController::class, 'toggleEnable'])->name('announcements.enabled');
    Route::resource('administrators', AdminController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('professors', ProfessorController::class);
    Route::resource('schedules', ScheduleController::class);
    
    Route::group([
        'prefix' => 'schedules',
        'as' => 'schedules.'
    ], function () {
        Route::get('assign/{schedule}', [ScheduleController::class, 'assignView'])->name('assign.view');
        Route::post('assign/{schedule}', [ScheduleController::class, 'assign'])->name('assign');
        Route::put('finalized/{schedule}', [ScheduleController::class, 'finalize'])->name('finalize');
        Route::put('finalized-assigned-students/{schedule}', [ScheduleController::class, 'finalizeAssignedStudents'])->name('finalize.assigned.students');
    });

    Route::group([
        'prefix' => 'schedule/details',
        'as' => 'schedules.'
    ], function () {
        Route::post('/{schedule}', [ScheduleController::class, 'storeDetails'])->name('store.details');
        Route::delete('/{scheduleDetail}', [ScheduleController::class, 'destroyDetail'])->name('destroy.details');
        Route::put('/{schedule}/update/{scheduleDetail}', [ScheduleController::class, 'updateDetails'])->name('update.details');
    });

    Route::resource('students', StudentController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('registrars', RegistrarController::class);

    Route::group([
        'prefix' => 'exports',
        'as' => 'exports.'
    ], function () 
    {
        Route::post('registration-form/{student}', [ExportController::class, 'registrationForm'])->name('registration.form');
    });
});
