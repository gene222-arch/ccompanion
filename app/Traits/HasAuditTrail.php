<?php 
namespace App\Traits;

use App\Models\AuditTrail;

Trait HasAuditTrail
{
    public function auditTrails(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(AuditTrail::class, 'audit_trailable');
    }

    protected static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            $model->auditTrails()->create([
                'action' => 'Create'
            ]);
        });

        self::updated(function ($model) {
            $model->auditTrails()->create([
                'action' => 'Update'
            ]);
        });

        self::deleted(function ($model) {
            $model->auditTrails()->create([
                'action' => 'Delete'
            ]);
        });
    }
}