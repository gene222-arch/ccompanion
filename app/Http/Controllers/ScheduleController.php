<?php

namespace App\Http\Controllers;

use App\Http\Requests\Schedule\AssignRequest;
use App\Http\Requests\ScheduleDetailsRequest;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\ScheduleService;
use App\Http\Requests\ScheduleRequest;
use App\Models\Professor;
use App\Models\ScheduleDetail;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Administrator|Administrator|Registrar');
    }
    
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

    public function assignView(Schedule $schedule)
    {
        return view('app.schedule.assign', [
            'students' => Student::with('user:id,name')
                ->where([
                    [ 'course_id', $schedule->course_id ],
                    [ 'department_id', $schedule->department_id ]
                ])
                ->get(),
            'schedule' => Schedule::query()
                ->with([
                    'details.subject',
                    'studentGrades'
                ])
                ->withCount('details')
                ->find($schedule->id),
        ]);
    }

    public function assign(AssignRequest $request, Schedule $schedule, ScheduleService $service)
    {
        $studentCount = $request->collect('student_ids')->count();

        $result = $service->assign($schedule, $request->student_ids);

        return gettype($result) !== 'string'
            ? Redirect::route('schedules.index')
                ->with([
                    'successMessage' => "{$studentCount} students assigned a schedule successfully."
                ])
            : Redirect::route('schedules.index')
                ->with([
                    'successMessage' => 'Assign student failed.'
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

        $schedule = Schedule::create($data);

        return Redirect::route('schedules.show', $schedule->id)
            ->with([
                'successMessage' => 'Schedule created successfully.'
            ]);
    }

    /**
     * Store a newly created resource of schedule details in storage.
     *
     * @param  \App\Http\Requests\ScheduleRequest  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function storeDetails(ScheduleDetailsRequest $request, Schedule $schedule)
    {
        $schedule->details()->create($request->validated());

        return Redirect::route('schedules.show', $schedule->id)
            ->with([
                'successMessage' => 'Schedule added successfully.'
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
        $details = ScheduleDetail::with([
            'subject',
            'professor'
        ])
            ->where('schedule_id', $schedule->id)
            ->get();

        $schedule = Schedule::query()
            ->with([
                'course',
                'department'
            ])
            ->withCount('details')
            ->find($schedule->id);

        return view('app.schedule.show', [
            'schedule' => $schedule,
            'details' => $details,
            'subjects' => Subject::all(['id', 'name']),
            'professors' => Professor::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        if ($schedule->is_finalized) {
            return Redirect::back();
        }

        return view('app.schedule.edit', [
            'departments' => Department::all(['id', 'name']),
            'courses' => Course::all(['id', 'name']),
            'schedule' => $schedule
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ScheduleRequest  $request
     * @param  \App\Models\Schedule  $schedule
     * @param  \App\Services\ScheduleService  $service
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, Schedule $schedule, ScheduleService $service)
    {
        $data = array_merge($request->validated(), [
            'code' => $service->scheduleCode($request->course_id)
        ]);

        $schedule->update($data);

        return Redirect::route('schedules.index')
            ->with([
                'successMessage' => $schedule->code .  ' updated successfully.'
            ]);
    }

  /**
     * Store a newly created resource of schedule details in storage.
     *
     * @param  \App\Http\Requests\ScheduleRequest  $request
     * @param  \App\Models\Schedule  $schedule
     * @param  \App\Models\ScheduleDetail  $scheduleDetail
     * @return \Illuminate\Http\Response
     */
    public function updateDetails(ScheduleDetailsRequest $request, Schedule $schedule, ScheduleDetail $scheduleDetail)
    {
        $schedule->details()
            ->find($scheduleDetail->id)
            ->update($request->validated());

        return Redirect::route('schedules.show', $schedule->id)
            ->with([
                'successMessage' => 'Schedule added successfully.'
            ]);
    }

    /**
     * Store a newly created resource of schedule details in storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function finalize(Schedule $schedule)
    {
        $schedule->update([
            'is_finalized' => true
        ]);

        return Redirect::route('schedules.index')
            ->with([
                'successMessage' => "{$schedule->code} finalized successfully."
            ]);
    }

    public function finalizeAssignedStudents(Schedule $schedule)
    {
        $schedule->update([
            'is_assigned_students_finalized' => true
        ]);

        return Redirect::route('schedules.assign', $schedule->id)
            ->with([
                'successMessage' => "{$schedule->code} assigned students was finalized successfully."
            ]);
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

    public function destroyDetail(ScheduleDetail $scheduleDetail)
    {
        $id = $scheduleDetail->schedule_id;
        $scheduleDetail->delete();

        return Redirect::route('schedules.show', $id)
            ->with([
                'successMessage' => 'Schedule deleted successfully.'
            ]);
    }
}
