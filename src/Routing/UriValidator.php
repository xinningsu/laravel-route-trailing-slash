<?php

namespace Sulao\LRTS\Routing;

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
        $path = $request->getPathInfo() ?: '/';

        return preg_match(
            $route->getCompiled()->getRegex(),
            rawurldecode($path)
        );
    }
}
