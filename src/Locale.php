<?php

namespace Sun\Locale;

use App;

class Locale
{
    public function getLocale()
    {
        return App::getLocale();
    }

    public function tableName()
    {
        return config('locale.table');
    }

    public function tablePostfix()
    {
        return config('locale.table_postfix');
    }

    public function foreignColumnName()
    {
        return 'locale_code';
    }
}
