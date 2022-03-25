<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Console\Command;

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
        $schedules = Schedule::all();

        $schedules->map(function ($schedule) 
        {
            $endDate = Carbon::parse($schedule->end_date);

            if ($endDate->isPast()) {
                $schedule->update([
                    'is_semester_finished' => true
                ]);
            }
        });
    }
}
