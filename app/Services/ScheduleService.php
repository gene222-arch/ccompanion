<?php 
namespace App\Services;

use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ScheduleService
{
    public function scheduleCode(int $courseID): string
    {
        $courseCode = Course::find($courseID)->code;

        $id = Schedule::all()->count() ? Schedule::all()->last()->value('id') + 1 : 1;
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
}