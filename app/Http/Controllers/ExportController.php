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
}
