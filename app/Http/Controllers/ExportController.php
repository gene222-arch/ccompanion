<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\SerialCode;
use App\Services\ExportService;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;

class ExportController extends Controller
{

    public function registrationForm(Student $student, Schedule $schedule, ExportService $service)
    {
        $student = Student::with('user')->find($student->id);

        $scheduleDetails = Schedule::with([
            'course',
            'details.subject',
            'details.professor'
        ])
            ->find($schedule->id)
            ->details;

        $scheduleBySubjects = [];
        
        foreach ($scheduleDetails as $detail) {
            $scheduleBySubjects[$detail->subject->code][] = $detail;
        }

        $data = [];

        foreach ($scheduleBySubjects as $subject => $subjectDetails) 
        {
            $schedule_ = [
                'professor' => $subjectDetails[0]->professor->name(),
                'section' => $schedule->section,
                'units' => $subjectDetails[0]->subject->units,
                'name' => $subjectDetails[0]->subject->name
            ];

            $subjectDetails = collect($subjectDetails);
            
            $data[$subject] = $schedule_ + [
                'day' => $subjectDetails->map->day->join(' - '),
                'room' => $subjectDetails->map->room->join(' - '),
                'time' => $subjectDetails->map(function ($sched, $index) use ($service, $subjectDetails) {
                    return $service->time($sched->from, $sched->to, count($subjectDetails), $index);
                })->join(' - '),
            ];
        }

        $serialCode = SerialCode::generate();

        $pdf = PDF::loadView('exports.registration-form', [
            'schedules' => $data,
            'schedule' => $schedule,
            'student' => $student,
            'serialCode' => $serialCode
        ])->setPaper('a4', 'landscape');

        return $pdf->download($student->student_id . ' - Registration Form.pdf'); 
    }

    public function comCard(int $studentID, int $scheduleID)
    {
        $serialCode = SerialCode::first();
        $schedule = Schedule::query()
            ->with([
                'studentGrades' => fn ($q) => $q->where('student_id', $studentID),
                'studentGrades.subject',
                'details.professor'
            ])
            ->withAvg('studentGrades', 'grade')
            ->withAvg('studentGrades', 'grade_point_equivalence')
            ->find($scheduleID);

        $totalUnits = $schedule->studentGrades->sum(fn ($sg) => $sg->subject->units);
        $totalUnitsPassed = $schedule->studentGrades->sum(fn ($sg) => $sg->status === 'Passed' ? $sg->subject->units : 0);
        $totalUnitsFailed = $schedule->studentGrades->sum(fn ($sg) => $sg->status === 'Failed' ? $sg->subject->units : 0);
        $totalUnitsINC = $schedule->studentGrades->sum(fn ($sg) => $sg->status === 'Incomplete' ? $sg->subject->units : 0);

        $data = [
            'schedule' => $schedule,
            'student' => Student::with(['course', 'department'])->find($studentID),
            'serialCode' => $serialCode,
            'totalUnits' => $totalUnits,
            'totalUnitsPassed' => $totalUnitsPassed,
            'totalUnitsFailed' => $totalUnitsFailed,
            'totalUnitsINC' => $totalUnitsINC,
            'status' => $totalUnits === $totalUnitsPassed ? 'Passed' : 'Failed'
        ];

        $pdf = PDF::loadView('exports.com-card', $data)->setPaper('a4', 'landscape');

        return $pdf->stream(Student::find($studentID) . ' - Com Form.pdf'); 
    }
}
