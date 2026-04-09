<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use SleepingOwl\Admin\Traits\OrderableModel;

/**
 * Class Scheme
 * @package App\Models
 */
class Decoration extends RememberableModel
{
    use OrderableModel;

    protected $fillable = ['code', 'name'];

    /**
     * @return HasMany
     */
    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class);
    }
}
