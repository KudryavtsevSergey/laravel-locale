<?php

namespace Sun\Locale;

use Illuminate\Contracts\Routing\Registrar as Router;
use Illuminate\Support\Facades\Facade as IlluminateFacade;
use Route;

class Facade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return 'Locale';
    }
}
