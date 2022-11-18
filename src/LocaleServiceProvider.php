<?php

namespace Sun\Locale;

use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerMigrations();
        $this->registerPublishing();
    }

    protected function registerMigrations(): void
    {
        if ($this->app->runningInConsole() && Locale::$runsMigrations) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/locale.php' => config_path('locale.php')
            ], 'locale');
        }
    }

    public function register(): void
    {
        $this->app->singleton(Facade::FACADE_ACCESSOR, Locale::class);

        $this->mergeConfigFrom(__DIR__ . '/../config/locale.php', 'locale');
    }
}
