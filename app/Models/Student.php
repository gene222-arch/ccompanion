<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function semester(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Semester::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
