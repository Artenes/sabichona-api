<?php

namespace Sabichona\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Sabichona\Traits\Uuids;

/**
 * Knowledge is any kind of information.
 *
 * Class Knowledge
 * @package Sabichona\Models
 */
class Knowledge extends Model
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
     * The name of the table.
     *
     * @var string
     */
    protected $table = 'knowledges';

    /**
     * The fillable fields.
     *
     * @var array
     */
    protected $fillable = ['content'];

    /**
     * Gets the knowledge url.
     *
     * @return string
     */
    public function url()
    {

        return route('knowledges.show', [$this->id]);

    }

    /**
     * Retrieves the knowledge from the database.
     *
     * @param $location
     * @param null $search
     * @return LengthAwarePaginator
     */
    public static function search($location, $search)
    {

        return static::where('content', 'like', "%{$search}%")
            ->where('location_uuid', $location)
            ->orderBy('created_at', 'desc')
            ->paginate(config('pagination.per_page'));

    }

    /**
     * Checks if there is a knowledge at the location.
     *
     * @param $location
     * @return bool
     */
    public static function isThereSomethingAt($location)
    {

        return static::where('location_uuid', $location)->count() > 0;

    }

    /**
     * Gets a random knowledge from the given location.
     *
     * @param $location
     * @return mixed
     */
    public static function random($location)
    {

        return static::with('user', 'location')->where('location_uuid', $location)->inRandomOrder()->first();

    }

    /**
     * Checks if the knowledge was created by the user of the current location.
     *
     * @return bool
     */
    public function isForeign()
    {

        return $this->user->location_uuid != $this->location_uuid;

    }

    /**
     * Format the knowledge data.
     *
     * @return array
     */
    public function present()
    {

        return [

            'uuid' => $this->uuid,
            'content' => $this->content,
            'image' => !empty($this->image_medium) ? Storage::url($this->image_medium) : null,
            'attachment' => !empty($this->attachment) ? Storage::url($this->attachment) : null,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'is_foreign' => $this->isForeign(),
            'user' => $this->presentUser(),
            'location' => $this->location->present(),
            'useful' => $this->useful_count,
            'useless' => $this->useless_count,
            'share' => $this->share_count,

        ];

    }

    /**
     * Presents a user.
     *
     * @return array
     */
    public function presentUser()
    {

        if ($this->user)
            return $this->user->present();

        $name = empty($this->user_name) ? trans('strings.anonymous') : $this->user_name;

        return [
            'name' => $name,
            'picture' => Storage::url(config('images.default_profile')),
            'profile' => null,
        ];

    }

    /**
     * Defines the relation to an user.
     *
     * @return BelongsTo
     */
    public function user()
    {

        return $this->belongsTo(User::class, 'user_uuid', 'uuid');

    }

    /**
     * Defines the relation to a location.
     *
     * @return BelongsTo
     */
    public function location()
    {

        return $this->belongsTo(Location::class, 'location_uuid', 'uuid');

    }

}