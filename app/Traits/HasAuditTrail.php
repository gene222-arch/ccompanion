<?php 
namespace App\Traits;

use App\Models\AuditTrail;

Trait HasAuditTrail
{
    public function auditTrails(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(AuditTrail::class, 'audit_trailable');
    }
}