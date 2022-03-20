<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'subject_id',
        'professor_id',
        'day',
        'from',
        'to'
    ];
}
