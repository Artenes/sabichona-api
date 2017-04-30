<?php

namespace Sabichona\Models;

use Illuminate\Database\Eloquent\Model;
use Sabichona\Traits\Uuids;

class Location extends Model
{

    use Uuids;

    /**
     * The primary key will be the uuid.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * There will not be any auto incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Format the location data.
     *
     * @return array
     */
    public function present()
    {

        return [

            'uuid' => $this->uuid,
            'label' => $this->label,
            'city' => $this->city,

        ];

    }

}