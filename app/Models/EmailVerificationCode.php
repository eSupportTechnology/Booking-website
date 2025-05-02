<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerificationCode extends Model
{
    protected $fillable = [
        'email',
        'code',
        'expires_at',
    ];

    protected $dates = ['expires_at'];

    public $timestamps = true;

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }
}
