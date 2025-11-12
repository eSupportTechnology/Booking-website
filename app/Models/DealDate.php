<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealDate extends Model
{
    protected $fillable = [
        'deal_id',
        'available_date',
        'is_weekend'
    ];

    protected $casts = [
        'available_date' => 'date',
        'is_weekend' => 'boolean'
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}