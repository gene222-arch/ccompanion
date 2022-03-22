<?php 
namespace App\Services;

use Carbon\Carbon;

class ExportService
{
    public function time(string $from, string $to, int $timeCount, int $index) 
    {
        $time = Carbon::parse($from)->format('g:i A') . ' - ' . Carbon::parse($to)->format('g:i A');

        return ($timeCount > 1 && ($timeCount - 1 !== $index)) ? $time.'/' : $time;
    }
}