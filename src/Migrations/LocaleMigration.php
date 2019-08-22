<?php

namespace Sun\Locale\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Sun\Locale\Locale;

abstract class LocaleMigration extends Migration
{
    /**
     * @var Locale
     */
    private $locale;

    public function __construct()
    {
        $this->locale = app('Locale');
    }

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
        return "{$this->getTableName()}{$this->locale->tablePostfix()}";
    }

    protected function addForeignField(Blueprint $table, string $keyName)
    {
        $table->bigInteger($keyName)->unsigned();
    }

    public function up()
    {
        Schema::create($this->getTableNameWithPostfix(), function (Blueprint $table) {
            $this->addForeignField($table, $this->getTableForeignKeyName());
            $table->string($this->locale->foreignColumnName(), 2);

            $table->foreign($this->getTableForeignKeyName())
                ->references($this->getTablePrimaryKeyName())
                ->on($this->getTableName())
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign($this->locale->foreignColumnName())
                ->references("code")
                ->on($this->locale->tableName())
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary([$this->getTableForeignKeyName(), $this->locale->foreignColumnName()]);

            $this->getLocaleTableFields($table);
        });
    }

    public function down()
    {
        Schema::table($this->getTableNameWithPostfix(), function (Blueprint $table) {
            $table->dropForeign("{$this->getTableNameWithPostfix()}_{$this->getTableForeignKeyName()}_foreign");
            $table->dropForeign("{$this->getTableNameWithPostfix()}_{$this->locale->foreignColumnName()}_foreign");
        });

        Schema::dropIfExists($this->getTableNameWithPostfix());
    }
}
