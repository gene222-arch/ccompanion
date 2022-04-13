<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'audit_trailable_id',
        'audit_trailable_type',
        'action_done_by'
    ];

    /**
     * Get the parent auditTrailable models.
     */
    public function auditTrailable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
