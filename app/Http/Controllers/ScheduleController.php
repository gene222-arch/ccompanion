<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Schedule;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\ScheduleService;
use App\Http\Requests\ScheduleRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::query()
            ->with([
                'course',
                'department'
            ])
            ->withCount('details')
            ->get();

        return view('app.schedule.index', [
            'schedules' => $schedules
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.schedule.create', [
            'departments' => Department::all(['id', 'name']),
            'courses' => Course::all(['id', 'name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ScheduleRequest  $request
     * @param  \App\Services\ScheduleService  $service
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request, ScheduleService $service)
    {
        $data = array_merge($request->validated(), [
            'code' => $service->scheduleCode($request->course_id)
        ]);

        Schedule::create($data);

        return Redirect::route('schedules.index')
            ->with([
                'successMessage' => 'Schedule created successfully.'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $code = $schedule->code;
        $schedule->delete();

        return Redirect::route('schedules.index')
            ->with([
                'successMessage' => "{$code} deleted successfully."
            ]);
    }
}
