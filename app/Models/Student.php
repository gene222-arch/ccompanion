<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use App\Traits\HasAuditTrail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAuditTrail;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'department_id',
        'student_id',
        'first_name',
        'last_name',
        'guardian',
        'contact_number',
        'birthed_at'
    ];

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function grades(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function isScheduled(): bool
    {
        if (! $this->grades) return false;

        return $this
            ->grades
            ->map
            ->schedule()
            ->map
            ->where([
                [ 'is_assigned_students_finalized', true ],
                [ 'is_semester_finished', false ]
            ])
            ->count();
    }
}
