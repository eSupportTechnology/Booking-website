<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CustomerAccountDeletionToken extends Model
{
    protected $fillable = ['email', 'token', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public static function createToken(string $email): string
    {
        // Delete any existing tokens for this email
        static::where('email', $email)->delete();

        $token = bin2hex(random_bytes(32));

        static::create([
            'email' => $email,
            'token' => $token,
            'expires_at' => Carbon::now()->addHours(24), // Token expires in 24 hours
        ]);

        return $token;
    }

    public static function findValidToken(string $token): ?self
    {
        return static::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();
    }
}
