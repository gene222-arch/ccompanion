<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \App\Services\DashboardService  $service
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(DashboardService $service)
    {
        return view('app.dashboard', $service->index());
    }
}
