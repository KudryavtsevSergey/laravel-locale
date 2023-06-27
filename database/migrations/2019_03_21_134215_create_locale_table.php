<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Sun\Locale\LocaleConfig;

class CreateLocaleTable extends Migration
{
    public function up(): void
    {
        Schema::create(LocaleConfig::tableName(), function (Blueprint $table): void {
            $table->string('code', 2)->primary();
            $table->string('country', 2)->unique();
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(LocaleConfig::tableName());
    }
}
