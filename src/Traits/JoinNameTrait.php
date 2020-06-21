<?php

namespace Sun\Locale\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Query\JoinClause;
use Sun\Locale\LocaleConfig;

trait JoinNameTrait
{
    protected function joinName(Builder $query, ?string $foreignKey = null, ?string $localKey = null, ?string $foreignTable = null, ?string $localTable = null, ?string $alias = null)
    {
        $this->joinModelName($query, $this, $foreignKey, $localKey, $foreignTable, $localTable, $alias);
    }

    protected function joinModelName(Builder $query, Eloquent $model, ?string $foreignKey = null, ?string $localKey = null, ?string $foreignTable = null, ?string $localeTable = null, ?string $alias = null)
    {
        $localKey = $localKey ?? $model->getKeyName();
        $localeTable = $localeTable ?? $model->getTable();
        $foreignKey = $foreignKey ?? $model->getForeignKey();
        $foreignTable = $foreignTable ?? $localeTable . LocaleConfig::tablePostfix();

        $tableName = is_null($alias) ? $foreignTable : $alias;
        $table = $foreignTable . (is_null($alias) ? '' : sprintf(' as %s', $alias));

        $query->leftJoin($table, function (JoinClause $join) use ($foreignKey, $localeTable, $localKey, $tableName) {
            $first = $this->printTableColumn($tableName, $foreignKey);
            $second = $this->printTableColumn($localeTable, $localKey);
            $column = $this->printTableColumn($tableName, LocaleConfig::foreignColumnName());

            $join->on($first, '=', $second)
                ->where($column, '=', LocaleConfig::getLocale());
        });
    }

    private function printTableColumn(string $table, string $column): string
    {
        return sprintf('%s.%s', $table, $column);
    }
}
