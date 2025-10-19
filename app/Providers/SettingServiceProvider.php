<?php

namespace App\Providers;

use App\Repositories\GeneralSettingRepository;
use App\Repositories\Interfaces\GeneralSettingInterface;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('setting', function () {
            return new GeneralSettingRepository();
        });
    }

    public function boot(): void
    {
        //
    }
}
