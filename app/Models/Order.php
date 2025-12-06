<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_code',
        'customer_name',
        'total_amount',
        'status',
        'payment_method',
        'ip_address',
        'user_agent',
        'paid_at',
        'prepared_at',
        'completed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'prepared_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
