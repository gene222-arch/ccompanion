<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Services\GradeService;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class StudentGradesImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;

    public Schedule $schedule;
    public GradeService $service;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
        $this->service = new GradeService();
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $grade = (($row['prelim'] + $row['midterm'] + $row['finals']) / 3);
        $status = $grade >= 60 ? 'Passed' : 'Failed';

        return new Grade([
            'student_id' => Student::firstWhere('student_id', $row['student_id'])->id,
            'schedule_id' => $this->schedule->id,
            'subject_id' => Subject::firstWhere('code', $row['subject_code'])->id,
            'grade' => $grade,
            'grade_point_equivalence' => $this->service->gradePointEquivalence($grade),
            'status' => $status
        ]);
    }

    public function onError(Throwable $e)
    {
        // dd($e->getMessage());
    }
}
