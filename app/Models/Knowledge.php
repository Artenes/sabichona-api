<?php

namespace Sabichona\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Knowledge is any kind of information.
 *
 * Class Knowledge
 * @package Sabichona\Models
 */
class Knowledge extends Model
{

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
     * @param null $search
     * @return Collection
     */
    public static function remember($search = null)
    {

        if ($search === null)
            return static::get();

        return static::where('content', 'like', "%{$search}%")->get();

    }

    /**
     * Gets the knowledge excerpt.
     *
     * @return string
     */
    public function excerpt()
    {

        if (strlen($this->content) > 97)
            return substr($this->content, 0, 97) . '...';

        return $this->content;

    }

}