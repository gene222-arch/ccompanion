<?php

namespace App\Models;

use App\Models\Student;
use App\Traits\HasAuditTrail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory;
    use HasAuditTrail;
    
    protected $fillable = [
        'student_id',
        'year_level',
        'type'
    ];

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
