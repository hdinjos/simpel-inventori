<?php

namespace App\Traits;

use Godruoyi\Snowflake\Snowflake;

trait HasSnowflakeId
{
    /**
     * Boot trait untuk auto generate snowflake id
     */
    protected static function bootHasSnowflakeId()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = self::generateSnowflakeId();
            }
        });
    }

    /**
     * Generate Snowflake ID
     */
    protected static function generateSnowflakeId(): int
    {
        static $snowflake;

        if (!$snowflake) {
            $snowflake = new Snowflake(
                config('snowflakeid.datacenter_id'),
                config('snowflakeid.worker_id')
            );
        }

        return $snowflake->id();
    }

     /**
     * auto convert to string
     */
    public function initializeHasSnowflakeId()
    {
        $this->casts['id'] = 'string';
    }
}
