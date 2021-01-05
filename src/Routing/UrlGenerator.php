<?php

namespace Sulao\LRTS\Routing;

use Sulao\LRTS\Helper;

class UrlGenerator extends \Illuminate\Routing\UrlGenerator
{
    /**
     * Format the given URL segments into a single URL.
     *
     * @param  string  $root
     * @param  string  $path
     * @param  \Illuminate\Routing\Route|null  $route
     * @return string
     */
    public function format($root, $path, $route = null)
    {
        return Helper::appendTrailingSlashes(
            parent::format($root, $path, $route),
            $path
        );
    }

    /**
     * Generate an absolute URL to the given path.
     *
     * @param string    $path
     * @param mixed     $extra
     * @param bool|null $secure
     *
     * @return string
     */
    public function to($path, $extra = [], $secure = null)
    {
        return Helper::appendTrailingSlashes(
            parent::to($path, $extra, $secure),
            $path
        );
    }

    /**
     * Get the Route URL generator instance.
     *
     * @return RouteUrlGenerator
     */
    protected function routeUrl()
    {
        if (! $this->routeGenerator) {
            $this->routeGenerator = new RouteUrlGenerator(
                $this,
                $this->request
            );
        }

        return $this->routeGenerator;
    }
}
