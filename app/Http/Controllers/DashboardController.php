<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;

class DashboardController extends Controller
{
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
