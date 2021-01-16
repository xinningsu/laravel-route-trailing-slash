<?php

namespace Sulao\LRTS\Routing;

use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Sulao\LRTS\Helper;

class UrlGenerator extends \Illuminate\Routing\UrlGenerator
{
    /**
     * Get the URL for a given route instance.
     *
     * @param  Route  $route
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     *
     * @throws UrlGenerationException
     */
    public function toRoute($route, $parameters, $absolute)
    {
        $url = parent::toRoute($route, $parameters, $absolute);

        if (Str::endsWith($route->originalUri, '/')) {
            $arr = explode('?', $url);
            $arr[0] = Helper::appendSlashes($arr[0], $route->originalUri);
            $url = implode('?', $arr);
        }

        return $url;
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
        return Helper::appendSlashes(
            parent::to($path, $extra, $secure),
            $path
        );
    }
}
