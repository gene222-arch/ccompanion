<?php 
namespace App\Services;

use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function index(): array
    {
        DB::statement('SET SQL_MODE = "" ');

        $monthlyActivitiesSet = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $monthlyRegisteredStudentsSet = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        $monthlyRegisteredStudents = DB::select(
            "SELECT 
                    MONTH(created_at) - 1 as month,
                    COUNT(*) as student_count
                FROM 
                    students 
                GROUP BY 
                    MONTH(created_at)
            "
        );

        $monthlyActivities = DB::select(
            "SELECT 
                    MONTH(created_at) - 1 as month,
                    COUNT(*) as activity_count
                FROM 
                    audit_trails 
                GROUP BY 
                    MONTH(created_at)
            "
        );

        foreach ($monthlyActivities as $monthlyActivity) {
            $monthlyActivitiesSet[$monthlyActivity->month] = $monthlyActivity->activity_count;
        }

        foreach ($monthlyRegisteredStudents as $monthlyRegisteredStudent) {
            $monthlyRegisteredStudentsSet[$monthlyRegisteredStudent->month] = $monthlyRegisteredStudent->student_count;
        }

        return [
            'administratorCount' => User::role('Administrator')->count(),
            'registrarCount' => User::role('Registrar')->count(),
            'studentCount' => User::role('Student')->count(),
            'courseCount' => Course::count(),
            'monthlyActivities' => $monthlyActivitiesSet,
            'monthlyRegisteredStudents' => $monthlyRegisteredStudentsSet,
            'userCanViewMontlyActivities' => match(Auth::user()->roles->first()->name) {
                'Super Administrator' => true,
                'Administrator' => true,
                'Registrar' => false,
                'Student' => false
            },
            'userCanViewMonthlyRegisteredStudents' => match(Auth::user()->roles->first()->name) {
                'Super Administrator' => true,
                'Administrator' => true,
                'Registrar' => true,
                'Student' => false
            },
        ];
    }
}