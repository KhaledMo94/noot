<?php

namespace App\Models;

use App\Traits\ActivityScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceProvider extends Model
{
    use HasTranslations, HasFactory, ActivityScopeTrait;

    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'status',
        'image',
        'options',
        'moderator_id',
        'free_trail_start_date',
        'free_trail_end_date',
    ];

    protected $casts = [
        'options'                           =>'array',
        'free_trail_start_date'             =>'datetime',
        'free_trail_end_date'               =>'datetime',
    ];

    protected $appends = [
        'in-free-trail',
        'image_url'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class , 'moderator_id');
    }

    public function getInFreeTrailAttribute() :bool
    {
        return $this->free_trail_start_date <= now() && $this->free_trail_end_date >= now();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
