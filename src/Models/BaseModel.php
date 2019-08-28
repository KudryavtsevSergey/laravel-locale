<?php

namespace Sun\Locale\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Sun\Locale\Traits\JoinNameTrait;

abstract class BaseModel extends Eloquent
{
    use JoinNameTrait;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    private function locales()
    {
        return $this->allLocales()->wherePivot($this->locale->foreignColumnName(), '=', $this->locale->getLocale());
    }

    private function allLocales()
    {
        $table = $this->getTable();
        $foreignKey = $this->getForeignKey();

        return $this->belongsToMany(Locale::class, "{$table}{$this->locale->tablePostfix()}", $foreignKey, $this->locale->foreignColumnName());
    }

    public function existLocales()
    {
        return $this->allLocales()->exists();
    }

    public function createLocales($attributes = [])
    {
        $this->allLocales()->attach($this->locale->getLocale(), $attributes);
    }

    public function replaceLocales($attributes = [])
    {
        $this->deleteLocales();
        $this->createLocales($attributes);
    }

    public function deleteLocales()
    {
        $this->locales()->detach();
    }

    public function deleteAllLocales()
    {
        return $this->allLocales()->detach();
    }
}
