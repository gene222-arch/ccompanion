<?php

namespace App\Imports;

use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Services\GradeService;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class StudentGradesImport implements ToModel, WithHeadingRow, WithValidation, WithUpserts
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

    public function rules(): array
    {
        $studentIDs = $this->schedule->studentGrades->map->student->map->student_id->toArray();

        return [
            'student_id' => function($attribute, $value, $onFailure) use ($studentIDs) {
                if (! in_array($value, $studentIDs)) {
                     $onFailure('The selected student id is not included in the schedule.');
                }
            },
            'subject_code' => ['string', 'exists:subjects,code'],
            'prelim' => ['numeric', 'min:0', 'max:100'],
            'midterm' => ['numeric', 'min:0', 'max:100'],
            'finals' => ['numeric', 'min:0', 'max:100']
        ];
    }

    public function customValidationMessages()
    {
        return [
            'student_id.in' => 'The selected student is not included in the schedule.',
            'subject_code.exists' => 'The selected subject is invalid'
        ];
    }

    public function uniqueBy(): string|array
    {
        return [
            'schedule_id',
            'student_id',
            'subject_id'
        ];
    }
}
