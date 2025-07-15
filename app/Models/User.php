<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Mail\PartnerResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
        ];
    }

    // Scope for Google authenticated users
    public function scopeGoogleUsers($query)
    {
        return $query->whereNotNull('google_id');
    }

    // Check if user registered via Google
    public function isGoogleUser(): bool
    {
        return !empty($this->google_id);
    }

    //partners relationship
    public function partner()
    {
        return $this->hasOne(Partner::class);
    }

    public function customerPersonalDetail()
    {
        return $this->hasOne(CustomerPersonalDetails::class);
    }

    
}
