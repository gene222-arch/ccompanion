<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationalLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'year_level',
        'semester',
        'upcoming_year_level',
        'upcoming_semester'
    ];

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
