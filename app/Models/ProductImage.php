<?php

namespace App\Models;

use App\Traits\HasImageAttributeTrait;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasImageAttributeTrait;

    protected $fillable = [
        'product_id',
        'image',
    ];

    protected $appends = [
        'image_url'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
