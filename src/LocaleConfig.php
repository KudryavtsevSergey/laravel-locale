<?php

declare(strict_types=1);

namespace Sun\Locale;

use Illuminate\Support\Facades\App;

class LocaleConfig
{
    public const FOREIGN_COLUMN_NAME = 'locale_code';

    public static function getLocale(): string
    {
        return App::getLocale();
    }

    public static function tableName(): string
    {
        return config('locale.table');
    }

    public static function tablePostfix(): string
    {
        return config('locale.table_postfix');
    }
}
