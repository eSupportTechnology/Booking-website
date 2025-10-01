<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerSettings extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'bio',
        'timezone',
        'language',
        'currency',
        'notification_preferences',
        'payout_settings',
        'two_factor_enabled',
        'last_password_change',
        'commission_rate'
    ];

    protected $casts = [
        'notification_preferences' => 'array',
        'payout_settings' => 'array',
        'two_factor_enabled' => 'boolean',
        'last_password_change' => 'datetime',
        'commission_rate' => 'decimal:4'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}