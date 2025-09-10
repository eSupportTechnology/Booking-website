<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'admin';

    protected $fillable = [
        'username',
        'email',
        'password',
        'status',
        'approved_by',
        'approved_at',
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
            'approved_at' => 'datetime',
        ];
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function getPermissionsByCategory(): array
    {
        $permissions = $this->getAllPermissions();
        
        return [
            'dashboard' => $permissions->filter(fn($p) => str_contains($p->name, 'dashboard')),
            'users' => $permissions->filter(fn($p) => str_contains($p->name, 'customer') || str_contains($p->name, 'partner')),
            'property' => $permissions->filter(fn($p) => str_contains($p->name, 'apartment') || str_contains($p->name, 'home') || str_contains($p->name, 'hotel') || str_contains($p->name, 'alternative')),
            'rental' => $permissions->filter(fn($p) => str_contains($p->name, 'taxi') || str_contains($p->name, 'airport')),
            'admin_management' => $permissions->filter(fn($p) => str_contains($p->name, 'admin'))
        ];
    }
}
