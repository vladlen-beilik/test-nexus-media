<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Order extends Model
{
    protected $fillable = [
        'foreign_id',
        'customer_id',
        'total_price',
        'financial_status',
        'fulfillment_status',
        'foreign_created_at',
        'foreign_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'foreign_created_at' => 'datetime',
            'foreign_updated_at' => 'datetime',
            'updated_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function customer(): Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
