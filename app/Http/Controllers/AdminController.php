<?php

namespace App\Http\Controllers;

use App\Http\Requests\Administrator\StoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.admin.index', [
            'administrators' => User::role('Administrator')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Administrator\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $administrator = User::create($request->validated() + [
            'password' => Hash::make($request->password)
        ]);
        
        $administrator->assignRole(Role::findByName('Administrator'));

        return Redirect::route('administrators.index')
            ->with([
                'successMessage' => 'Administrator created successfully.'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $administrator
     * @return \Illuminate\Http\Response
     */
    public function show(User $administrator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $administrator
     * @return \Illuminate\Http\Response
     */
    public function edit(User $administrator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $administrator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $administrator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $administrator
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $administrator)
    {
        $userName = $administrator->name;
        $administrator->delete();

        return Redirect::route('administrators.index')
            ->with([
                'successMessage' => $userName . ' deleted successfully.'
            ]);
    }
}
