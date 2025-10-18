<?php

namespace App\Models;

use App\Traits\HasImageAttributeTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelPackageTools\Concerns\Package\HasTranslations;

class ProductCategory extends Model
{
    use HasTranslations, HasImageAttributeTrait;

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public $translatable = [
        'name',
        'description',
    ];

    protected $appends = [
        'image_url'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
