<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\RequirePassword as Middleware;

class RequirePassword extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
