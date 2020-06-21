<?php

namespace Sun\Locale;

use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/locale.php' => config_path('locale.php')
        ], 'locale');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/locale.php', 'locale');
    }
}
