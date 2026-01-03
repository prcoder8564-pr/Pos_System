<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'phone',
        'email',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // Helper Methods
    public function totalPurchaseAmount()
    {
        return $this->purchases()->sum('total');
    }

    public function totalDueAmount()
    {
        return $this->purchases()->sum('due_amount');
    }
}