<?php

namespace App\Models;

use App\Traits\HasImageAttributeTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations, HasImageAttributeTrait;

    protected $fillable = [
        'name',
        'description',
        'before_price',
        'after_price',
        'image',
        'service_provider_id',
        'product_category_id',
    ];

    protected $casts = [
        'before_price'              => 'decimal:2',
        'after_price'              => 'decimal:2',
    ];

    public $translatable = [
        'name',
        'description',
    ];

    protected $appends = [
        'image_url'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
