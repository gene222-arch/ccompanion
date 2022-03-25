<?php

namespace App\Models;

use App\Models\Grade;
use App\Models\Course;
use App\Models\Department;
use App\Traits\HasAuditTrail;
use App\Models\ScheduleDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAuditTrail;

    protected $fillable = [
        'code',
        'department_id',
        'course_id',
        'semester_type',
        'year_level',
        'section',
        'is_finalized',
        'is_semester_finished',
        'is_assigned_students_finalized',
        'start_date',
        'end_date'
    ];

    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ScheduleDetail::class);
    }

    public function studentGrades(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Grade::class);
    }
}
