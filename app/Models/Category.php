<?php

namespace App\Models;

use App\Traits\ActivityScopeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory , HasTranslations , ActivityScopeTrait;
    protected $guarded = [];

    public $translatable = ['name','description'];

    public function serviceProviders()
    {
        return $this->hasMany(ServiceProvider::class);
    }

}
