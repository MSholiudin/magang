<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'transaction_number',
        'sale_date',
        'total_amount',
        'customer_name'
    ];

    protected $casts = [
        'sale_date' => 'date', // Auto convert ke Carbon
        'total_amount' => 'decimal:2'
    ];

    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }
}
