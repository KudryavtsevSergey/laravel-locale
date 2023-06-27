<?php

declare(strict_types=1);

namespace Sun\Locale\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Sun\Locale\Scopes\LocaleableScope;

abstract class AbstractLocaleModel extends Eloquent implements Localeable
{
    use LocaleableTrait;

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new LocaleableScope());
    }
}
