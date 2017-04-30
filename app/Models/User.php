<?php

namespace Sabichona\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Sabichona\Traits\Uuids;

class User extends Model
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
     * Gets the user profile url.
     *
     * @return string
     */
    public function url()
    {

        return route('users.show', [$this->uuid]);

    }

    /**
     * Format the user data.
     *
     * @return array
     */
    public function present()
    {

        $picture = Storage::exists($this->picture) ? Storage::url($this->picture) : Storage::url(config('images.default_profile'));

        return [
            'name' => $this->name,
            'picture' => $picture,
            'profile' => $this->url(),
        ];

    }

}