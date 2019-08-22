<?php

namespace Sun\Locale;

use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/locale.php' => config_path('locale.php')
        ], 'locale');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/locale.php', 'locale');

        $this->app->singleton('Locale', function () {
            return new Locale();
        });

        $this->app->alias('Locale', Locale::class);
    }
}
