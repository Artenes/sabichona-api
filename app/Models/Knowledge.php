<?php

namespace Sabichona\Models;

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

}