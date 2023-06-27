<?php

declare(strict_types=1);

namespace Sun\Locale;

class Locale
{
    public static bool $runsMigrations = true;

    public static function ignoreMigrations(): void
    {
        static::$runsMigrations = false;
    }
}
