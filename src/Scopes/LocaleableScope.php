<?php

declare(strict_types=1);

namespace Sun\Locale\Scopes;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Sun\Locale\LocaleConfig;
use Sun\Locale\Traits\JoinNameTrait;

class LocaleableScope implements Scope
{
    use JoinNameTrait;

    public function apply(Builder $builder, Model $model): void
    {
        $this->joinName(
            $builder,
            $model->getForeignKey(),
            $model->getKeyName(),
            sprintf('%s%s', $model->getTable(), LocaleConfig::tablePostfix()),
            $model->getTable()
        );
    }
}
