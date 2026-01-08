<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id');
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    // Helper Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isCashier()
    {
        return $this->role === 'cashier';
    }

    //     * Get role badge color
//  */
    public function getRoleBadgeAttribute()
    {
        return [
            'admin' => 'danger',
            'manager' => 'warning',
            'cashier' => 'info',
        ][$this->role] ?? 'secondary';
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status == 'active' ? 'success' : 'secondary';
    }
}