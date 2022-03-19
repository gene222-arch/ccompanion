<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professor extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'department_id',
        'prefix',
        'employment_type',
        'first_name',
        'last_name',
        'birthed_at'
    ];

    public function subjects(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Subject::class)
            ->as('subjects');
    }

    public function name(): string 
    {
        return "{$this->prefix} {$this->first_name} {$this->last_name}";
    }
}
