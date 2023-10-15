<?php

declare(strict_types=1);

namespace Sun\Locale\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Sun\Locale\LocaleConfig;

abstract class LocaleMigration extends Migration
{
    protected abstract function getTableName(): string;

    protected function getTablePrimaryKeyName(): string
    {
        return 'id';
    }

    protected function getTableForeignKeyName(): string
    {
        return sprintf('%s_%s', $this->getTableName(), $this->getTablePrimaryKeyName());
    }

    protected function getLocaleTableFields(Blueprint $table): void
    {
        $table->string('name');
    }

    private function getTableNameWithPostfix(): string
    {
        return sprintf('%s%s', $this->getTableName(), LocaleConfig::tablePostfix());
    }

    protected function addForeignField(Blueprint $table, string $keyName): void
    {
        $table->bigInteger($keyName)->unsigned();
    }

    protected function getPrimaryName(): string
    {
        return sprintf('%s_primary', $this->getTableNameWithPostfix());
    }

    public function up(): void
    {
        Schema::create($this->getTableNameWithPostfix(), function (Blueprint $table): void {
            $this->addForeignField($table, $this->getTableForeignKeyName());
            $table->string(LocaleConfig::FOREIGN_COLUMN_NAME, 2);

            $table->foreign($this->getTableForeignKeyName())
                ->references($this->getTablePrimaryKeyName())
                ->on($this->getTableName())
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign(LocaleConfig::FOREIGN_COLUMN_NAME)
                ->references('code')
                ->on(LocaleConfig::tableName())
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->primary([
                $this->getTableForeignKeyName(),
                LocaleConfig::FOREIGN_COLUMN_NAME,
            ], $this->getPrimaryName());

            $this->getLocaleTableFields($table);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->getTableNameWithPostfix());
    }
}
