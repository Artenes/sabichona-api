<?php

namespace Sabichona\Http\Middleware;

use Closure;

/**
 * Middleware that adds a header to the response to allow CORS.
 * @package Sabichona\Http\Middleware
 */
class AllowCORS
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        $response->headers->add(['Access-Control-Allow-Origin' => '*']);

        return $response;

    }

}