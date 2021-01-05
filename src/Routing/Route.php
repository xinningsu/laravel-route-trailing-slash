<?php

namespace Sulao\LRTS\Routing;

use Illuminate\Routing\Matching\UriValidator as LaravelUriValidator;
use Sulao\LRTS\Helper;

class Route extends \Illuminate\Routing\Route
{
    /**
     * Create a new Route instance.
     *
     * @param array|string   $methods
     * @param string         $uri
     * @param \Closure|array $action
     *
     * @return void
     */
    public function __construct($methods, $uri, $action)
    {
        parent::__construct($methods, $uri, $action);

        $this->replaceUriValidator();
    }

    /**
     * Add a prefix to the route URI.
     *
     * @param string $prefix
     *
     * @return $this
     */
    public function prefix($prefix)
    {
        $uri = $this->uri;
        $return = parent::prefix($prefix);
        $this->uri = Helper::appendTrailingSlashes($this->uri, $uri);

        return $return;
    }

    /**
     * Replace UriValidator
     */
    protected function replaceUriValidator()
    {
        static $replaced;

        if (!$replaced) {
            $validators = static::getValidators();
            foreach ($validators as $key => $validator) {
                if ($validator instanceof LaravelUriValidator) {
                    static::$validators[$key] = new UriValidator();
                }
            }

            $replaced = true;
        }
    }
}
