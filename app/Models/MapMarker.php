<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MapMarker
 * @package App\Models
 */
class MapMarker extends RememberableModel
{
    /**
     * Rememberable model cache tag
     * @var string
     */
    protected $rememberCacheTag = 'main_page_map';

    /**
     * Fully shit transport property values
     * @var array
     */
    protected static $tranportCodes = [
        0 => 'Пешком',
        1 => 'На авто',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'active', 'name', 'lat', 'lon', 'address', 'distance', 'time', 'image', 'transport', 'map_category_id',
        'map_subcategory_id'
    ];

    /**
     * @return BelongsTo
     */
    public function mapCategory(): BelongsTo
    {
        return $this->belongsTo(MapCategory::class);
    }

    /**
     * @return BelongsTo
     */
    public function mapSubcategory(): BelongsTo
    {
        return $this->belongsTo(MapSubcategory::class);
    }

    /**
     * Returns transport show property value
     * @param $value
     * @return mixed
     */
    public function getTransportAttribute($value)
    {
        $this->transportStr = self::$tranportCodes[$value];
        return $value;
    }

    /**
     * Returns transports code for selects
     * @return array
     */
    public static function getTransports()
    {
        return self::$tranportCodes;
    }
}
