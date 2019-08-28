<?php

namespace Sun\Locale;

use App;

class LocaleConfig
{
    public static function getLocale()
    {
        return App::getLocale();
    }

    public static function tableName()
    {
        return config('locale.table');
    }

    public static function tablePostfix()
    {
        return config('locale.table_postfix');
    }

    public static function foreignColumnName()
    {
        return 'locale_code';
    }
}
