<?php

namespace App\Models;

use App\Traits\HasAuditTrail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAuditTrail;

    protected $fillable = [
        'code',
        'name',
        'units'
    ];

    public $timestamps = false;
}
