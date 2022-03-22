<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Services\GradeService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Grade\StoreRequest;
use Illuminate\Support\Facades\Redirect;

class GradeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $schedule = Schedule::with('studentGrades.subject')
            ->whereRelation('studentGrades', fn ($q) => $q->where('student_id', $student->id))
            ->find($student->activeSchedule()->id);

        return view('app.grade.create', [
            'schedule' => $schedule,
            'student' => Student::with(['user', 'course', 'department'])->find($student->id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Grade\StoreRequest  $request
     * @param \App\Services\GradeService  $service
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, GradeService $service)
    {
        $service->update(
            Schedule::find($request->schedule_id),
            $request->except('schedule_id')
        );

        return Redirect::route('students.index')
            ->with([
                'successMessage' => 'Student graded successfully.'
            ]);
    }
}
