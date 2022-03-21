<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'administratorCount' => User::role('Administrator')->count(),
            'registrarCount' => User::role('Registrar')->count(),
            'studentCount' => User::role('Student')->count(),
            'courseCount' => Course::count()
        ];

        return view('app.dashboard', $data);
    }
}
