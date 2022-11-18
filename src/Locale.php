<?php

namespace Sun\Locale;

class Locale
{
    public static bool $runsMigrations = true;

    public static function ignoreMigrations(): void
    {
        static::$runsMigrations = false;
    }
}
