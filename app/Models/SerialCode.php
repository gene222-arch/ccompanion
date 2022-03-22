<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'is_verified'
    ];
}
