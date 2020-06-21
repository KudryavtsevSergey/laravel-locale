<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Sun\Locale\LocaleConfig;

class CreateLocaleTable extends Migration
{
    public function up()
    {
        Schema::create(LocaleConfig::tableName(), function (Blueprint $table) {
            $table->string('code')->primary();
            $table->string('country');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists(LocaleConfig::tableName());
    }
}
