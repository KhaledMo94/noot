<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Order extends Model
{
    use HasTranslations;
    protected $fillable = [
        'user_id',
        'user_name',
        'user_phone_number',
        'service_provider_id',
        'service_provider_name',
        'product_id',
        'product_name',
        'product_price',
        'cashier_id',
        'cashier_name',
        'nafad_confirmation',
        'nafad_confirmation_id',
    ];

    public $translatable = [
        'product_name',
    ];

    protected $casts = [
        'nafad_confirmation'            => 'boolean',
        'product_price'                 => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(OrderTransaction::class);
    }

}
