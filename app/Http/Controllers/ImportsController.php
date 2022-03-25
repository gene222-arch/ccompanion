<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Imports\StudentGradesImport;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Import\ImportStudentGradeRequest;

class ImportsController extends Controller
{
    public function grades(ImportStudentGradeRequest $request, Schedule $schedule)
    {
        (new StudentGradesImport($schedule))
            ->import($request->file('excel_file'));
        
        return Redirect::route('schedules.index')
            ->with([
                'successMessage' => 'Student grades imported successfully.'
            ]);
    }
}
