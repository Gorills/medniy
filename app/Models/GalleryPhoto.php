<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GalleryPhoto
 * @package App\Models
 */
class GalleryPhoto extends RememberableModel
{
    /**
     * @return BelongsTo
     */
    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }
}
