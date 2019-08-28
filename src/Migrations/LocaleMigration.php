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
        return "{$this->getTableName()}_{$this->getTablePrimaryKeyName()}";
    }

    protected function getLocaleTableFields(Blueprint $table)
    {
        $table->string('name', 255);
    }

    private function getTableNameWithPostfix()
    {
        return $this->getTableName() . LocaleConfig::tablePostfix();
    }

    protected function addForeignField(Blueprint $table, string $keyName)
    {
        $table->bigInteger($keyName)->unsigned();
    }

    public function up()
    {
        Schema::create($this->getTableNameWithPostfix(), function (Blueprint $table) {
            $this->addForeignField($table, $this->getTableForeignKeyName());
            $table->string(LocaleConfig::foreignColumnName(), 2);

            $table->foreign($this->getTableForeignKeyName())
                ->references($this->getTablePrimaryKeyName())
                ->on($this->getTableName())
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign(LocaleConfig::foreignColumnName())
                ->references("code")
                ->on(LocaleConfig::tableName())
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary([$this->getTableForeignKeyName(), LocaleConfig::foreignColumnName()]);

            $this->getLocaleTableFields($table);
        });
    }

    public function down()
    {
        Schema::table($this->getTableNameWithPostfix(), function (Blueprint $table) {
            $table->dropForeign("{$this->getTableNameWithPostfix()}_{$this->getTableForeignKeyName()}_foreign");
            $table->dropForeign("{$this->getTableNameWithPostfix()}_" . LocaleConfig::foreignColumnName() . "_foreign");
        });

        Schema::dropIfExists($this->getTableNameWithPostfix());
    }
}
