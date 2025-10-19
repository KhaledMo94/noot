<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\Interfaces\GeneralSettingInterface;
use Illuminate\Support\Facades\Cache;

class GeneralSettingRepository
{
    public array $settings = [];

    public function __construct()
    {
        $cached = Cache::get('general-settings');

        if ($cached instanceof \Illuminate\Support\Collection) {
            $this->settings = $cached->pluck('setting_value', 'setting_key')->toArray();
        } elseif (is_array($cached) && !empty($cached)) {
            $this->settings = $cached;
        } else {
            $this->settings = Setting::pluck('setting_value', 'setting_key')->toArray();
            Cache::forever('general-settings', $this->settings);
        }
    }

    public function all(): array
    {
        return $this->settings;
    }

    public function get(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    public function refresh(): void
    {
        $this->settings = Setting::pluck('setting_value', 'setting_key')->toArray();
        Cache::forever('general-settings', $this->settings);
    }
}
