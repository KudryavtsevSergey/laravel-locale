<?php

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
            $table->string(LocaleConfig::foreignColumnName(), 2);

            $table->foreign($this->getTableForeignKeyName())
                ->references($this->getTablePrimaryKeyName())
                ->on($this->getTableName())
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign(LocaleConfig::foreignColumnName())
                ->references('code')
                ->on(LocaleConfig::tableName())
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary([$this->getTableForeignKeyName(), LocaleConfig::foreignColumnName()], $this->getPrimaryName());

            $this->getLocaleTableFields($table);
        });
    }

    public function down(): void
    {
        Schema::table($this->getTableNameWithPostfix(), function (Blueprint $table): void {
            $table->dropForeign(sprintf('%s_%s_foreign', $this->getTableNameWithPostfix(), $this->getTableForeignKeyName()));
            $table->dropForeign(sprintf('%s_%s_foreign', $this->getTableNameWithPostfix(), LocaleConfig::foreignColumnName()));
        });

        Schema::dropIfExists($this->getTableNameWithPostfix());
    }
}
