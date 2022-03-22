<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SerialCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'is_verified'
    ];

    public static function generate()
    {
        return self::create([
            'code' => Str::of(Str::random(3))->upper() . '-' . time()
        ]);
    }
}
