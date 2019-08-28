<?php

namespace Sun\Locale\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Sun\Locale\LocaleConfig;
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
        return $this->allLocales()->wherePivot(LocaleConfig::foreignColumnName(), '=', LocaleConfig::getLocale());
    }

    private function allLocales()
    {
        $table = $this->getTable();
        $foreignKey = $this->getForeignKey();

        return $this->belongsToMany(Locale::class, $table . LocaleConfig::tablePostfix(), $foreignKey, LocaleConfig::foreignColumnName());
    }

    public function existLocales()
    {
        return $this->allLocales()->exists();
    }

    public function createLocales($attributes = [])
    {
        $this->allLocales()->attach(LocaleConfig::getLocale(), $attributes);
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
