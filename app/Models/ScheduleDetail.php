<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\Professor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public $timestamps = false;

    public function professor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }

    public function subject(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
