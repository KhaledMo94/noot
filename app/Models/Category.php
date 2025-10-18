<?php

namespace App\Models;

use App\Traits\ActivityScopeTrait;
use App\Traits\HasImageAttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations, ActivityScopeTrait, HasImageAttributeTrait;
    
    protected $guarded = [];

    protected $appends = [
        'image_url'
    ];

    public $translatable = ['name', 'description'];

    public function serviceProviders()
    {
        return $this->hasMany(ServiceProvider::class);
    }
}
