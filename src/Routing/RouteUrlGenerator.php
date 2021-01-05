<?php

namespace Sulao\LRTS\Routing;

use Sulao\LRTS\Helper;

class RouteUrlGenerator extends \Illuminate\Routing\RouteUrlGenerator
{
    /**
     * Replace all of the wildcard parameters for a route path.
     *
     * @param string $path
     * @param array  $parameters
     *
     * @return string
     */
    protected function replaceRouteParameters($path, array &$parameters)
    {
        return Helper::appendTrailingSlashes(
            parent::replaceRouteParameters($path, $parameters),
            $path
        );
    }
}
