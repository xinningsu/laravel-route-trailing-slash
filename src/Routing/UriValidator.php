<?php

namespace Sulao\LRTS\Routing;

use Sulao\LRTS\Helper;

class UriValidator extends \Illuminate\Routing\Matching\UriValidator
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param \Illuminate\Routing\Route $route
     * @param \Illuminate\Http\Request  $request
     *
     * @return bool
     */
    public function matches(
        \Illuminate\Routing\Route $route,
        \Illuminate\Http\Request $request
    ) {
        $match = parent::matches($route, $request);

        if ($match && in_array(Router::$mismatchAction, [404, 301, 302])) {
            $pathSlash = Helper::getTrailingSlashes($request->getPathInfo());
            $routeSlash = Helper::getTrailingSlashes($route->originalUri);
            if ($routeSlash !== $pathSlash) {
                if (Router::$mismatchAction == 404) {
                    abort(404);
                }

                $uri = $request->getUri();
                $arr = explode('?', $uri);
                $arr[0] = Helper::appendSlashes($arr[0], $route->originalUri);
                $uri = implode('?', $arr);

                abort(Router::$mismatchAction, '', ['Location' => $uri]);
            }
        }

        return $match;
    }
}
