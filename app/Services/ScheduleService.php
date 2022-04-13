<?php 
namespace App\Services;

use App\Models\Course;
use App\Models\Grade;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleService
{
    public function scheduleCode(int $courseID): string
    {
        $courseCode = Course::find($courseID)->code;

        $id = Schedule::all()->count() ? Schedule::all()->last()->id + 1 : 1;
        $length = Str::length($id);

        $prependZeros = match($length) {
            1 => '000',
            2 => '00',
            3 => '0',
            4 => ''
        };

        $uniqueID = $courseCode . ' - ' . Carbon::now()->format('Y') . ' - ' . $prependZeros . $id;

        return $uniqueID;
    }

    public function finalizeAssignedStudents(Schedule $schedule)
    {
        try {
            $upcomingYear = function (int $year): int {
                return match($year) {
                    1 => 2,
                    2 => 3,
                    3 => 4
                };
            };

            DB::transaction(function () use ($schedule, $upcomingYear)
            {
                $schedule->update([
                    'is_assigned_students_finalized' => true
                ]);

                $data = [
                    'year_level' => $schedule->year_level,
                    'semester' => $schedule->semester_type,
                    'upcoming_year_level' => $schedule->semester_type === 'Second' ? $upcomingYear($schedule->year_level) : $schedule->year_level,
                    'upcoming_semester' => $schedule->semester_type === 'First' ? 'Second' : 'First'
                ];

                # Delete current educational level
                $schedule
                    ->studentGrades
                    ->map
                    ->student
                    ->unique()
                    ->map(fn ($student) => $student->educationalLevel()->delete());

                # Create new educational level
                $schedule
                    ->studentGrades
                    ->map
                    ->student
                    ->unique()
                    ->map(fn ($student) => $student->educationalLevel()->create($data));
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    public function assign(Schedule $schedule, array $studentIDs): bool|string
    {
        try {
            DB::transaction(function () use ($schedule, $studentIDs)
            {
                $subjectIDs = $schedule->details->map->subject_id;

                if ($schedule->studentGrades()->count())
                {
                    $schedule->studentGrades()->delete();
                }

                foreach ($studentIDs as $studentID) 
                {
                    foreach ($subjectIDs as $subjectID) 
                    {
                        Grade::updateOrCreate([
                            'student_id' => $studentID,
                            'schedule_id' => $schedule->id,
                            'subject_id' => $subjectID
                        ], []);
                    }
                }
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}