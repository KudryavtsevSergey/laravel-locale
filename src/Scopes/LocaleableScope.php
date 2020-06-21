<?php

namespace Sun\Locale\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Sun\Locale\Traits\JoinNameTrait;

class LocaleableScope implements Scope
{
    use JoinNameTrait;

    public function apply(Builder $builder, Eloquent $model)
    {
        $this->joinModelName($builder, $model);
    }
}
