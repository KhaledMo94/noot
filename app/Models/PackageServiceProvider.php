<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PackageServiceProvider extends Model
{
    protected $fillable = [
        'service_provider_id',
        'package_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date'            =>'datetime',
        'end_date'              =>'datetime',
    ];

    protected $appends = [
        'valid',
    ];

    public function getValidAttribute() :bool
    {
        return $this->start_date <= now() && $this->end_date >= now();
    }

    public function scopeValid(Builder $builder)
    {
        return $builder->where('start_date','>',now())
            ->where('end_date','<',now());
    }
}
