<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    protected $fillable = [
        'order_id',
        'departure_date',
        'payable_amount',
    ];

    protected $casts = [
        'departure_date'                =>'date',
        'payable_amount'                =>'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
