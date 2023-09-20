<?php

declare(strict_types=1);

namespace Sun\Locale\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Sun\Locale\LocaleConfig;

trait JoinNameTrait
{
    protected function joinName(
        Builder $query,
        string $foreignKey,
        string $localKey,
        string $foreignTable,
        string $localeTable,
        string $alias = null
    ): Builder {
        $tableName = $alias === null ? $foreignTable : $alias;
        $table = $foreignTable . ($alias === null ? '' : sprintf(' as %s', $alias));

        return $query->leftJoin($table, static function (
            JoinClause $join
        ) use ($foreignKey, $localeTable, $localKey, $tableName) {
            $first = self::getTableColumn($tableName, $foreignKey);
            $second = self::getTableColumn($localeTable, $localKey);
            $column = self::getTableColumn($tableName, LocaleConfig::FOREIGN_COLUMN_NAME);

            $join->on($first, '=', $second)
                ->where($column, '=', LocaleConfig::getLocale());
        });
    }

    private static function getTableColumn(string $table, string $column): string
    {
        return sprintf('%s.%s', $table, $column);
    }
}
