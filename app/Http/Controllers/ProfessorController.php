<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Professor;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\ProfessorService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Professor\StoreRequest;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.professor.index', [
            'professors' => Professor::withCount('subjects')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.professor.create', [
            'departments' => Department::all(),
            'subjects' => Subject::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Professor\StoreRequest  $request
     * @param  \App\Services\ProfessorService  $service
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, ProfessorService $service)
    {
        $result = $service->create(
            $request->department_id,
            $request->prefix,
            $request->employment_type,
            $request->first_name,
            $request->last_name,
            $request->birthed_at,
            $request->subject_ids
        );

        return (gettype($result) !== 'string')
            ? Redirect::route('professors.index')
                ->with([
                    'successMessage' => 'Professor created successfully.'
                ])
            : Redirect::route('professors.index')
                ->with([
                    'successMessage' => 'Create professor failed.'
                ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function show(Professor $professor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function edit(Professor $professor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professor $professor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professor $professor)
    {
        $professorName = $professor->name();
        $professor->delete();

        return Redirect::route('professors.index')
            ->with([
                'successMessage' => $professorName . ' deleted successfully.'
            ]);
    }
}
