<?php

namespace Sun\Locale;

use Illuminate\Support\Facades\App;

class LocaleConfig
{
    public static function getLocale(): string
    {
        return App::getLocale();
    }

    public static function tableName(): ?string
    {
        return config('locale.table');
    }

    public static function tablePostfix(): ?string
    {
        return config('locale.table_postfix');
    }

    public static function foreignColumnName(): ?string
    {
        return 'locale_code';
    }
}
