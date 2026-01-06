<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'sale_id',
        'payment_type',
        'amount',
        'payment_method',
        'transaction_id',
        'note',
        'payment_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    // Relationships
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Helper Methods
    public function isPurchasePayment()
    {
        return $this->payment_type === 'purchase';
    }

    public function isSalePayment()
    {
        return $this->payment_type === 'sale';
    }
}