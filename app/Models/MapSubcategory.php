<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SleepingOwl\Admin\Traits\OrderableModel;

/**
 * Class MapSubcategory
 * @package App\Models
 */
class MapSubcategory extends RememberableModel
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
        'active', 'name', 'map_category_id',
    ];

    /**
     * Setting subcategory code
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->code = md5($value);
    }

    /**
     * @return BelongsTo
     */
    public function mapCategory(): BelongsTo
    {
        return $this->belongsTo(MapCategory::class);
    }

    /**
     * @return HasMany
     */
    public function mapMarkers(): HasMany
    {
        return $this->hasMany(MapMarker::class);
    }
}
