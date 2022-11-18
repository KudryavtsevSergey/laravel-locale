<?php

namespace Sun\Locale;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Facade extends IlluminateFacade
{
    public const FACADE_ACCESSOR = 'Locale';

    protected static function getFacadeAccessor(): string
    {
        return self::FACADE_ACCESSOR;
    }
}
