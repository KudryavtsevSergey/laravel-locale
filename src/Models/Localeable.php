<?php

namespace Sun\Locale\Models;

interface Localeable
{
    public function existLocales(): bool;

    public function createLocales($attributes = []): void;

    public function replaceLocales($attributes = []): void;

    public function deleteLocales(): int;

    public function deleteAllLocales(): int;
}
