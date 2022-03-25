<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EndSemesterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:end-semester';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'End the schedule`s semester';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $schedules = Schedule::query()->with('studentGrades.student')->where('is_semester_finished', false)->get();

        $upcomingYear = function (int $year): int {
            return match($year) {
                1 => 2,
                2 => 3,
                3 => 4
            };
        };

        $schedules->map(function ($schedule)  use ($upcomingYear)
        {
            $endDate = Carbon::parse($schedule->end_date);

            if ($endDate->isPast()) 
            {
                try {
                    DB::transaction(function () use ($schedule, $upcomingYear)
                    {
                        $schedule->update([
                            'is_semester_finished' => true
                        ]);
        
                        $schedule
                            ->studentGrades
                            ->map
                            ->student
                            ->unique()
                            ->each(function ($student) use ($schedule, $upcomingYear)
                            {
                                $data = [
                                    'year_level' => $schedule->year_level,
                                    'semester' => $schedule->semester_type,
                                    'upcoming_year_level' => $schedule->semester_type === 'Second' ? $upcomingYear($schedule->year_level) : $schedule->year_level,
                                    'upcoming_semester' => $schedule->semester_type === 'First' ? 'Second' : 'First'
                                ];

                                $student
                                    ->educationalLevel()
                                    ->updateOrCreate($data, $data);
                            });
                    });
                } catch (\Throwable $th) {
                    dd($th->getMessage());
                }
            }
        });
    }
}
