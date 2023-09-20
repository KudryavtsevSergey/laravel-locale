<?php

declare(strict_types=1);

namespace Sun\Locale\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Sun\Locale\LocaleConfig;
use Sun\Locale\Traits\JoinNameTrait;

trait LocaleableTrait
{
    use JoinNameTrait;

    public function existLocales(): bool
    {
        /** @var Builder $query */
        $query = $this->allLocales();
        return $query->exists();
    }

    public function createLocales(array $attributes = []): void
    {
        $this->allLocales()->attach(LocaleConfig::getLocale(), $attributes);
    }

    public function replaceLocales(array $attributes = []): void
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
            ->wherePivot(LocaleConfig::FOREIGN_COLUMN_NAME, '=', LocaleConfig::getLocale());
    }

    private function allLocales(): BelongsToMany
    {
        return $this->belongsToMany(
            Locale::class,
            sprintf('%s%s', $this->getTable(), LocaleConfig::tablePostfix()),
            $this->getForeignKey(),
            LocaleConfig::FOREIGN_COLUMN_NAME
        );
    }
}
