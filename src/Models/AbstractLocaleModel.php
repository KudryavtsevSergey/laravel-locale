<?php

namespace Sun\Locale\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Sun\Locale\Scopes\LocaleableScope;

abstract class AbstractLocaleModel extends Eloquent implements Localeable
{
    use LocaleableTrait;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LocaleableScope);
    }
}
