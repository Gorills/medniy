<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use SleepingOwl\Admin\Traits\OrderableModel;

/**
 * Class MapCategory
 * @package App\Models
 */
class MapCategory extends RememberableModel
{
    use OrderableModel;

    /**
     * Rememberable model cache tag
     * @var string
     */
    protected $rememberCacheTag = 'main_page_map';

    /**
     * @var array
     */
    protected $fillable = [
        'active', 'name',
    ];

    /**
     * Setting category key
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->code = md5($value);
    }

    /**
     * @return HasMany
     */
    public function mapSubcategories(): HasMany
    {
        return $this->hasMany(MapSubcategory::class);
    }

    /**
     * @return HasMany
     */
    public function mapMarkers(): HasMany
    {
        return $this->hasMany(MapMarker::class);
    }
}
