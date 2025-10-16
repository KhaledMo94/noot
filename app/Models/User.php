<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\ActivityScopeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable, HasApiTokens, ActivityScopeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'national_id',
        'phone_number',
        'country_code',
        'phone_verified_at',
        'image',
        'status',
        'fcm_token',
        'player_id',
        'qr_code',
        'otp_code',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'phone_verified_at' => 'datetime',
            'card_code' => 'string',
            'otp_expires_at' => 'datetime',
        ];
    }
    //-----------------------------

    protected $appends = [
        'type',
        'image_url',
        'is_phone_verified',
        'phone',
        'failed_orders_count'
    ];

    //-----------------------------------------------

    protected static function booted()
    {

        static::creating(function ($user) {
            do {
                $code = Str::uuid();
            } while (User::where('qr_code', $code)->exists());
            $user->qr_code = $code;
        });

    }

    public function getPhoneAttribute()
    {
        return $this->country_code . $this->phone_number;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getIsPhoneVerifiedAttribute()
    {
        return is_null($this->phone_verified_at) ? false : true;
    }

    public function ownedServiceProvider()
    {
        return $this->hasOne(ServiceProvider::class , 'moderator_id');
    }

}
