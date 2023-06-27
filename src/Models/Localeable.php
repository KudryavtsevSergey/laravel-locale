<?php

declare(strict_types=1);

namespace Sun\Locale\Models;

interface Localeable
{
    public function existLocales(): bool;

    public function createLocales(array $attributes = []): void;

    public function replaceLocales(array $attributes = []): void;

    public function deleteLocales(): int;

    public function deleteAllLocales(): int;
}
