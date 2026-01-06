<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'total_purchases',
        'is_active',
    ];

    protected $casts = [
        'total_purchases' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Helper Methods
    public function totalSalesAmount()
    {
        return $this->sales()->sum('total');
    }

    public function totalDueAmount()
    {
        return $this->sales()->sum('due_amount');
    }

    public function salesCount()
    {
        return $this->sales()->count();
    }
}