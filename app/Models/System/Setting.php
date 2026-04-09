<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class Setting
 * @package App\Models\System
 */
class Setting extends Model
{
    /**
     * Gets the setting value by code
     * @param $code
     * @return mixed
     */
    public static function get($code)
    {
        return Cache::remember('setting' . $code, 1440, function () use ($code) {
            return self::where('code', $code)->first()->value;
        });
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        Cache::forget('setting' . $this->code);
        return parent::save($options);
    }

    /**
     * Setting can not be deleted
     * @return bool
     */
    public function delete()
    {
        return false;
    }
}
