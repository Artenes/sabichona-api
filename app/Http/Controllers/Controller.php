<?php

namespace Sabichona\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Gets the current uuid location from the request.
     *
     * @return string
     */
    protected function getLocation()
    {

        $request = app('request');

        return $request->route('location');

    }

}
