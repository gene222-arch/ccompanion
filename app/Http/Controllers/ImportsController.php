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
        try {
           (new StudentGradesImport($schedule))
                ->import($request->file('excel_file'));

            return Redirect::route('schedules.assign.view', [
                'schedule' => $schedule->id
            ])
                ->with([
                    'successMessage' => 'Student grades imported successfully.'
                ]);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) 
        {
            $failures = $e->failures();

            foreach ($failures as $failure) 
            {
                $row = $failure->row(); // row that went wrong
                $attribute = $failure->attribute(); // either heading key (if using heading row concern) or column index
                $errors = $failure->errors(); // Actual error messages from Laravel validator
                $model = $failure->values(); // The values of the row that has failed.
    
                $message[] = "In column {$attribute}, an error occured at row #{$row}: {$model[$attribute]}, {$errors[0]}";
            }

            return Redirect::route('schedules.assign.view', [
                'schedule' => $schedule->id
            ])
                ->with([
                    'errorMessage' => $message
                ]);
        }
    }
}
