<?php

namespace App;

use League\Glide\Manipulators\Orientation;
use League\Glide\ServerFactory;

/**
 * Glide по умолчанию всегда подключает Orientation (EXIF). Без ext-exif Intervention падает с NotSupportedException.
 */
class GlideServerFactory extends ServerFactory
{
    public function getManipulators()
    {
        $manipulators = parent::getManipulators();

        if (!extension_loaded('exif')) {
            return array_values(array_filter($manipulators, function ($manipulator) {
                return !($manipulator instanceof Orientation);
            }));
        }

        return $manipulators;
    }
}
