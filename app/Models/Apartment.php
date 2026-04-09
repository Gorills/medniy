<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Apartment extends RememberableModel
{
    protected $fillable = [];

    /**
     * @return BelongsTo
     */
    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * @return BelongsTo
     */
    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    /**
     * @return BelongsTo
     */
    public function decoration(): BelongsTo
    {
        return $this->belongsTo(Decoration::class);
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        return json_decode($value);
    }
}
