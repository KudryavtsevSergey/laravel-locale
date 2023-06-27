<?php

declare(strict_types=1);

namespace Sun\Locale\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Query\JoinClause;
use Sun\Locale\LocaleConfig;

trait JoinNameTrait
{
    protected function joinName(
        EloquentBuilder $query,
        ?string $foreignKey = null,
        ?string $localKey = null,
        ?string $foreignTable = null,
        ?string $localeTable = null,
        ?string $alias = null
    ): QueryBuilder|EloquentBuilder|static {
        /** @var Eloquent $model */
        $model = $this;
        return $this->joinModelName($query, $model, $foreignKey, $localKey, $foreignTable, $localeTable, $alias);
    }

    protected function joinModelName(
        EloquentBuilder $query,
        Eloquent $model,
        ?string $foreignKey = null,
        ?string $localKey = null,
        ?string $foreignTable = null,
        ?string $localeTable = null,
        ?string $alias = null
    ): QueryBuilder|EloquentBuilder|static {
        $localKey = $localKey ?? $model->getKeyName();
        $localeTable = $localeTable ?? $model->getTable();
        $foreignKey = $foreignKey ?? $model->getForeignKey();
        $foreignTable = $foreignTable ?? $localeTable . LocaleConfig::tablePostfix();

        $tableName = $alias === null ? $foreignTable : $alias;
        $table = $foreignTable . ($alias === null ? '' : sprintf(' as %s', $alias));

        return $query->leftJoin($table, function (
            JoinClause $join
        ) use ($foreignKey, $localeTable, $localKey, $tableName) {
            $first = $this->printTableColumn($tableName, $foreignKey);
            $second = $this->printTableColumn($localeTable, $localKey);
            $column = $this->printTableColumn($tableName, LocaleConfig::FOREIGN_COLUMN_NAME);

            $join->on($first, '=', $second)
                ->where($column, '=', LocaleConfig::getLocale());
        });
    }

    private function printTableColumn(string $table, string $column): string
    {
        return sprintf('%s.%s', $table, $column);
    }
}
