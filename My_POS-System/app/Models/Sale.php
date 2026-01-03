<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'invoice_number',
        'subtotal',
        'tax',
        'discount',
        'total',
        'paid_amount',
        'due_amount',
        'status',
        'sale_date',
        'note',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'sale_date' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Helper Methods
    public function isPaid()
    {
        return $this->due_amount <= 0;
    }

    public function isPartiallyPaid()
    {
        return $this->paid_amount > 0 && $this->due_amount > 0;
    }

    public function isDue()
    {
        return $this->due_amount > 0;
    }

    public function calculateTotal()
    {
        return ($this->subtotal + $this->tax) - $this->discount;
    }

    public function totalProfit()
    {
        $profit = 0;
        foreach ($this->saleItems as $item) {
            $costPrice = $item->product->cost_price;
            $profit += ($item->price - $costPrice) * $item->quantity;
        }
        return $profit;
    }
}