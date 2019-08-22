<?php

namespace Sun\Locale\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Sun\Locale\Locale;

trait JoinNameTrait
{
    /**
     * @var Locale
     */
    protected $locale;

    public function __construct()
    {
        $this->locale = app('Locale');
    }

    /**
     * @param Builder $query
     * @param string|null $foreignKey
     * @param string|null $localKey
     * @param string|null $foreignTable
     * @param string|null $localTable
     * @param string|null $alias
     */
    protected function joinName(Builder $query, ?string $foreignKey = null, ?string $localKey = null, ?string $foreignTable = null, ?string $localTable = null, ?string $alias = null)
    {
        $localKey = $localKey ?? $this->getKeyName();
        $localTable = $localTable ?? $this->getTable();
        $foreignKey = $foreignKey ?? $this->getForeignKey();
        $foreignTable = $foreignTable ?? "{$localTable}{$this->locale->tablePostfix()}";

        $tableName = is_null($alias) ? $foreignTable : $alias;
        $table = $foreignTable . (is_null($alias) ? '' : " as {$alias}");

        $query->leftJoin($table, function (JoinClause $join) use ($foreignTable, $foreignKey, $localTable, $localKey, $tableName) {
            $join->on("{$tableName}.{$foreignKey}", '=', "{$localTable}.{$localKey}")
                ->where("{$tableName}.{$this->locale->foreignColumnName()}", '=', $this->locale->getLocale());
        });
    }
}
