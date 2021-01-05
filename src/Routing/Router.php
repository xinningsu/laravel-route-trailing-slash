<?php

namespace Sulao\LRTS\Routing;

use Sulao\LRTS\Helper;

class Router extends \Illuminate\Routing\Router
{
    /**
     * Prefix the given URI with the last prefix.
     *
     * @param  string  $uri
     * @return string
     */
    protected function prefix($uri)
    {
        return Helper::appendTrailingSlashes(parent::prefix($uri), $uri);
    }

    /**
     * Create a new Route object.
     *
     * @param array|string $methods
     * @param string       $uri
     * @param mixed        $action
     *
     * @return Route
     */
    public function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))
            ->setRouter($this)
            ->setContainer($this->container);
    }
}
