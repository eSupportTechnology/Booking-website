<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminSettings extends Model
{
    protected $fillable = [
        'admin_id',
        'full_name',
        'phone',
        'timezone',
        'language',
        'notification_preferences',
        'two_factor_enabled',
        'last_password_change',
        'commission_rate'
    ];

    protected $casts = [
        'notification_preferences' => 'array',
        'two_factor_enabled' => 'boolean',
        'last_password_change' => 'datetime',
        'commission_rate' => 'decimal:4'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get the global commission rate.
     */
    public static function getGlobalCommissionRate(): float
    {
        return static::first()?->commission_rate ?? 0.15;
    }
}