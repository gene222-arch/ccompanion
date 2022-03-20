<?php

namespace App\Http\Controllers;

use App\Http\Requests\Registrar\StoreRequest;
use App\Http\Requests\Registrar\UpdateRequest;
use App\Models\Department;
use App\Models\User;
use App\Models\Registrar;
use App\Services\RegistrarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RegistrarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.registrar.index', [    
            'registrars' => User::role('Registrar')->with('registrar.department')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.registrar.create', [
            'departments' => Department::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Registrar\StoreRequest  $request
     * @param  \App\Services\RegistrarService  $service
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, RegistrarService $service)
    {
        $result = $service->create(
            $request->first_name,
            $request->last_name,
            $request->birthed_at,
            $request->department_id,
            $request->email,
            $request->password
        );

        return gettype($result) !== 'string'
            ? Redirect::route('registrars.index')
                ->with([
                    'successMessage' => 'Registrar created successfully.'
                ])
            : Redirect::route('registrars.index')
                ->with([
                    'successMessage' => 'Create registrar failed.'
                ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registrar  $registrar
     * @return \Illuminate\Http\Response
     */
    public function show(Registrar $registrar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registrar  $registrar
     * @return \Illuminate\Http\Response
     */
    public function edit(Registrar $registrar)
    {
        return view('app.registrar.edit', [
            'departments' => Department::all(),
            'registrar' => Registrar::with('user')->find($registrar->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Registrar\UpdateRequest  $request
     * @param  \App\Models\Registrar  $registrar
     * @param  \App\Services\RegistrarService  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Registrar $registrar, RegistrarService $service)
    {
        $result = $service->update(
            $registrar,
            $request->first_name,
            $request->last_name,
            $request->birthed_at,
            $request->department_id,
            $request->email,
            $request->password
        );

        return gettype($result) !== 'string'
            ? Redirect::route('registrars.index')
                ->with([
                    'successMessage' => $registrar->first_name . ' updated successfully.'
                ])
            : Redirect::route('registrars.index')
                ->with([
                    'successMessage' => 'Registrar update failed.'
                ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registrar  $registrar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registrar $registrar)
    {
        $registrarName = $registrar->name;
        $user = User::find($registrar->user_id);

        $user->delete();
        $registrar->delete();

        return Redirect::route('departments.index')
            ->with([
                'successMessage' => $registrarName . ' deleted successfully.'
            ]);
    }
}
