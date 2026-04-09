<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use SleepingOwl\Admin\Traits\OrderableModel;

/**
 * Class Block
 * @package App\Models
 */
class Block extends RememberableModel
{
    use OrderableModel;

    /**
     * @var array
     */
    protected $fillable = [
        'active', 'name',
    ];

    /**
     * @return HasMany
     */
    public function galleryPhotos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class);
    }

    /**
     * @return HasMany
     */
    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class);
    }

    /**
     * @return HasMany
     */
    public function apartments()
    {
        return $this->hasMany(Apartment::class)
//            ->orderBy('rooms', 'asc');
//              ->groupBy('rooms')
            ;
    }

}
