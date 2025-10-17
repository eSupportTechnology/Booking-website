<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'from_currency',
        'to_currency',
        'rate',
        'cached_at'
    ];

    protected $casts = [
        'rate' => 'decimal:6',
        'cached_at' => 'datetime'
    ];
}