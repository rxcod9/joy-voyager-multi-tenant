<?php

namespace App\Routing;

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Str;

class Route extends RoutingRoute
{
    /**
     * Parse the controller.
     *
     * @return array
     */
    protected function parseControllerCallback()
    {
        return Str::parseCallback($this->action['uses']);
    }
}
