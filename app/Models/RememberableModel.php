<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

/**
 * Class RememberableModel
 * @package App\Models
 */
abstract class RememberableModel extends Model
{
    use Rememberable;

    /**
     * Cache life time in minutes
     * @var int
     */
    protected $rememberFor;

    /**
     * Cache tag
     * @var string
     */
    protected $rememberCacheTag;

    /**
     * Cache prefix
     * @var string
     */
    protected $rememberCachePrefix;

    /**
     * Cache driver
     * @var string
     */
    protected $rememberCacheDriver;

    /**
     * RememberableModel constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        if (!isset($this->rememberFor)) {
            $this->rememberFor = 1440;
        }

        if (!isset($this->rememberCacheTag)) {
            $this->rememberCacheTag = strtolower(
                preg_replace(
                    '/[^a-zA-Z]/',
                    '_',
                    (new \ReflectionClass($this))->getName()
                )
            );
        }

        parent::__construct($attributes);
    }

    /**
     * Dropping cache on save
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        static::flushCache();
        return parent::save($options);
    }

    /**
     * Dropping cache on delete
     * @return bool|null
     */
    public function delete()
    {
        static::flushCache();
        return parent::delete();
    }
}