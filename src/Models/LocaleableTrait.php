<?php

namespace Sun\Locale\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Sun\Locale\LocaleConfig;
use Sun\Locale\Traits\JoinNameTrait;

trait LocaleableTrait
{
    use JoinNameTrait;

    public function existLocales(): bool
    {
        return $this->allLocales()->exists();
    }

    public function createLocales($attributes = []): void
    {
        $this->allLocales()->attach(LocaleConfig::getLocale(), $attributes);
    }

    public function replaceLocales($attributes = []): void
    {
        $this->deleteLocales();
        $this->createLocales($attributes);
    }

    public function deleteLocales(): int
    {
        return $this->locales()->detach();
    }

    public function deleteAllLocales(): int
    {
        return $this->allLocales()->detach();
    }

    private function locales(): BelongsToMany
    {
        return $this->allLocales()
            ->wherePivot(LocaleConfig::foreignColumnName(), '=', LocaleConfig::getLocale());
    }

    private function allLocales(): BelongsToMany
    {
        return $this->belongsToMany(
            Locale::class,
            sprintf('%s%s', $this->getTable(), LocaleConfig::tablePostfix()),
            $this->getForeignKey(),
            LocaleConfig::foreignColumnName()
        );
    }
}
