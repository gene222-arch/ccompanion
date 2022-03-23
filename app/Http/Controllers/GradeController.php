<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Services\GradeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Grade\StoreRequest;

class GradeController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        $column = fn ($q) => $q->where([
            [ 'student_id', $student->id ],
            [ 'is_accessible_to_student', true ],
            [ 'status', '!=', 'Incomplete' ]
        ]);

        $schedules = Schedule::query()
            ->with([
                'course',
                'department',
                'studentGrades'
            ])
            ->whereRelation('studentGrades', $column)
            ->withAvg([ 'studentGrades' => $column ], 'grade_point_equivalence')
            ->withAvg([ 'studentGrades' => $column ], 'grade')
            ->withCount('details')
            ->orderBy('year_level')
            ->get();

        return view('app.grade.index', [
            'schedules' => $schedules
        ]);
    }

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

    public function show(int $scheduleID, int $studentID)
    {
        $schedule = Schedule::with('studentGrades.subject')
            ->whereRelation(
                'studentGrades', 
                fn ($q) => $q->where([
                    ['student_id', $studentID], 
                    [ 'is_accessible_to_student', true ]
                ])
            )
            ->find($scheduleID);

        $student = Student::with(['user', 'course', 'department'])->find($studentID);

        return view('app.grade.show', [
            'schedule' => $schedule,
            'student' => $student
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

    public function toggleStudentAccess(int $studentID, Schedule $schedule)
    {
        $schedule->studentGrades()->update([
            'is_accessible_to_student' => DB::raw('!is_accessible_to_student')
        ]);

        return Redirect::route('grades.edit', $studentID)
            ->with([
                'successMessage' => 'Grade visibility updated successfully.'
            ]);
        }
}
