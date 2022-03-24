<?php 
namespace App\Services;

use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class GradeService
{
    public function update(Student $student, Schedule $schedule, array $subjectGrades): bool|string
    {
        try {
            DB::transaction(function () use ($student, $schedule, $subjectGrades)
            {
                $studentGrades = $schedule->studentGrades;

                foreach ($subjectGrades as $subjectID => $value) 
                {
                    $subjectID = Str::replace('subject_id_', '', $subjectID);
                    $grade = floatval($value);

                    $studentGrades->map(function ($studentGrade) use ($student, $subjectID, $grade)
                    {
                        if (
                            ($subjectID == $studentGrade->subject_id) && 
                            ($studentGrade->student_id === $student->id)
                        )
                        {
                            if (! $grade) {
                                $studentGrade->update([
                                    'grade' => $grade,
                                    'status' => "Incomplete"
                                ]);
                            }

                            if ($grade) 
                            {
                                $gpe = $this->gradePointEquivalence($grade);

                                $studentGrade
                                    ->update([
                                        'grade' => $grade,
                                        'grade_point_equivalence' => $gpe,
                                        'status' => $grade >= 60 ? 'Passed' : 'Failed'
                                    ]);
                            }
                        }
                    });
                }
            });
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        
        return true;
    }

    public function gradePointEquivalence(float $grade)
    {
        if ($grade >= 96 && $grade <= 100) return 1.00;
        if ($grade >= 92 && $grade <= 95) return 1.25;
        if ($grade >= 88 && $grade <= 91) return 1.50;
        if ($grade >= 84 && $grade <= 87) return 1.75;
        if ($grade >= 80 && $grade <= 83) return 2.00;
        if ($grade >= 75 && $grade <= 79) return 2.25;
        if ($grade >= 70 && $grade <= 74) return 2.50;
        if ($grade >= 65 && $grade <= 69) return 2.75;
        if ($grade >= 60 && $grade <= 64) return 3;
        if ($grade <= 59) return 4;
    }
}