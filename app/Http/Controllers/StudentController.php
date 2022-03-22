<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Student\StoreRequest;
use App\Http\Requests\Student\UpdateRequest;
use App\Models\Course;
use App\Models\Department;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Administrator|Administrator|Registrar');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.student.index', [
            'students' => Student::with(['user:id,name,email', 'department:id,name'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.student.create', [
            'courses' => Course::all(['id', 'name']),
            'departments' => Department::all((['id', 'name']))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Student\StoreRequest  $request
     * @param  \App\Services\StudentService  $service
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, StudentService $service)
    {
        $result = $service->create(
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->course_id,
            $request->department_id,
            $request->guardian,
            $request->contact_number,
            $request->birthed_at
        );

        return gettype($result) !== 'string'
            ? Redirect::route('students.index')
                ->with([
                    'successMessage' => 'Student created successfully.'
                ])
            : Redirect::route('students.index')
                ->with([
                    'errorMessage' => 'Create student failed.'
                ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('app.student.edit', [
            'courses' => Course::all(['id', 'name']),
            'departments' => Department::all((['id', 'name'])),
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Student\UpdateRequest  $request
     * @param  \App\Models\Student  $student
     * @param  \App\Services\StudentService  $service 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Student $student, StudentService $service )
    {
        $studentName = $student->first_name;

        $result = $service->update(
            $student,
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->course_id,
            $request->department_id,
            $request->guardian,
            $request->contact_number,
            $request->birthed_at
        );

        return gettype($result) !== 'string'
            ? Redirect::route('students.index')
                ->with([
                    'successMessage' => "{$studentName} updated successfully."
                ])
            : Redirect::route('students.index')
                ->with([
                    'successMessage' => 'Student update failed.'
                ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $studentName = $student->user->name;

        $student->delete();
        $student->user()->delete();

        return Redirect::route('students.index')
            ->with([
                'successMessage' => $studentName . ' deleted successfully.'
            ]);
    }
}
