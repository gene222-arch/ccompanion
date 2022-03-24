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
                        Grade::create([
                            'student_id' => $studentID,
                            'schedule_id' => $schedule->id,
                            'subject_id' => $subjectID
                        ]);
                    }
                }
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
}