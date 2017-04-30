<?php

namespace Sabichona\Traits;

use Webpatser\Uuid\Uuid;

/**
 * Defines the usage of uuid in a model.
 * @package Sabichona\Traits
 */
trait Uuids
{

    /**
     * When creating a model, this method
     * will generate a new uuid.
     */
    protected static function boot()
    {

        parent::boot();

        static::creating(function ($model) {

            $primaryKey = $model->getKeyName();

            if (empty($model->{$primaryKey}))
                $model->{$primaryKey} = Uuid::generate(config('uuid.version'));

        });

    }

}