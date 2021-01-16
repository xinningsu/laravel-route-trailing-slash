<?php

namespace Sulao\LRTS\Routing;

class Router extends \Illuminate\Routing\Router
{
    /**
     * What to do when current route mismatched because of trailing slash,
     * null: do nothing.
     * 404: abort 404, not found exception will be threw.
     * 301/302: redirect to the url with trailing slash.
     *
     * @var null|int
     */
    public static $mismatchAction = null;

    /**
     * Add a route to the underlying route collection.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illuminate\Routing\Route
     */
    public function addRoute($methods, $uri, $action)
    {
        $route = parent::addRoute($methods, $uri, $action);
        $route->originalUri = $uri;

        return $route;
    }
}
