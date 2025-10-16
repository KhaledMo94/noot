<?php

namespace App\Models;

use App\Traits\ActivityScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Package extends Model
{
    use HasTranslations , ActivityScopeTrait;

    protected $guarded = [];

    protected $translatable = ['name', 'description'];

    protected $casts = [
        'price'                 => 'decimal:2',
        'valid_days'            => 'integer',
        'connections_count'     => 'integer',
        'cashiers_count'        => 'integer',
    ];

    public function serviceProviders()
    {
        return $this->belongsToMany(ServiceProvider::class, 'package_service_provider')
        ->withPivot(['start_date','end_date']);
    }
}
