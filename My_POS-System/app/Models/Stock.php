<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'last_updated',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'last_updated' => 'datetime',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper Methods
    public function addStock($quantity)
    {
        $this->quantity += $quantity;
        $this->last_updated = now();
        $this->save();
    }

    public function reduceStock($quantity)
    {
        $this->quantity -= $quantity;
        $this->last_updated = now();
        $this->save();
    }

    public function updateStock($quantity)
    {
        $this->quantity = $quantity;
        $this->last_updated = now();
        $this->save();
    }
}