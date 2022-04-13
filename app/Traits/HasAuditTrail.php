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
                'action' => 'Create',
                'action_done_by' => auth()->user()->name
            ]);
        });

        self::updated(function ($model) {
            $model->auditTrails()->create([
                'action' => 'Update',
                'action_done_by' => auth()->user()->name
            ]);
        });

        self::deleted(function ($model) {
            $model->auditTrails()->create([
                'action' => 'Delete',
                'action_done_by' => auth()->user()->name
            ]);
        });
    }
}