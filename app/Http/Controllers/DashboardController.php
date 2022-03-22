<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Schedule;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \App\Services\DashboardService  $service
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(DashboardService $service)
    {
        $user = Auth::user();

        if ($user->roles->first()->name === 'Student') 
        {
            $schedule = $user->student->activeSchedule();
            $schedule = Schedule::with([
                'details.subject',
                'details.professor'
            ])->find($schedule?->id);

            return view('app.student-dashboard', [
                'schedule' => $schedule,
                'student' => $user->student
            ]);
        }

        return view('app.dashboard', $service->index());
    }
}
