<?php

namespace Sun\Locale;

use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/locale.php' => config_path('locale.php')
        ], 'locale');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/locale.php', 'locale');
    }
}
