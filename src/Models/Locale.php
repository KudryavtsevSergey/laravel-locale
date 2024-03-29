<?php

declare(strict_types=1);

namespace Sun\Locale\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sun\Locale\LocaleConfig;

/**
 * @property string $code
 * @property string $country
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Locale extends Eloquent
{
    use SoftDeletes;
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = LocaleConfig::tableName();
    }

    protected $fillable = [
        'code',
        'country',
        'name',
    ];
}
