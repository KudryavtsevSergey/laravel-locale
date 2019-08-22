<?php

namespace Sun\Locale\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Locale
 *
 * @property string $code
 * @property string $country
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 * @package Sun\Locale\Models
 */
class Locale extends Eloquent
{
    use SoftDeletes;
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('locale.table');
    }

    protected $fillable = [
        'code',
        'country',
        'name'
    ];
}
