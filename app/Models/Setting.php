<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'setting_key',
        'setting_value',
    ];

    protected static function booted()
    {
        static::updated(fn() => self::flushAndSetCache());
        static::created(fn() => self::flushAndSetCache());
        static::deleted(fn() => self::flushAndSetCache());
    }

    public static function getValue($key, $default = null)
    {
        $settings = Cache::get('general-settings') ?? self::pluck('setting_value', 'setting_key')->toArray();
        return $settings[$key] ?? $default;
    }


    private static function flushAndSetCache(): void
    {
        // store as key => value array so consumers get consistent shape
        $data = self::pluck('setting_value', 'setting_key')->toArray();

        Cache::forget('general-settings'); // remove old cache
        Cache::forever('general-settings', $data); // refresh with current DB data (key => value)

        // If the repository singleton is bound, ask it to refresh its in-memory copy
        try {
            if (app()->bound('setting')) {
                $repo = app('setting');
                if (method_exists($repo, 'refresh')) {
                    $repo->refresh();
                }
            }
        } catch (\Throwable $e) {
            // avoid breaking save flow if app() isn't available in some contexts
        }
    }

    /**
     * Public helper to refresh settings cache and repository.
     * Useful when settings are changed via query builder (updateOrInsert) which
     * does not fire Eloquent model events.
     */
    public static function refreshCache(): void
    {
        self::flushAndSetCache();
    }
}
