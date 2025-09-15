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
        'last_password_change'
    ];

    protected $casts = [
        'notification_preferences' => 'array',
        'payout_settings' => 'array',
        'two_factor_enabled' => 'boolean',
        'last_password_change' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}