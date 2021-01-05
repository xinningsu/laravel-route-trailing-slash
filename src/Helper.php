<?php

namespace Sulao\LRTS;

class Helper
{
    /**
     * Append trail slashes
     *
     * @param string $path   the path to append trail slashes
     * @param string $origin the origin path with trail slashes
     *
     * @return string
     */
    public static function appendTrailingSlashes($path, $origin)
    {
        if ($path !== $origin && preg_match('~/+$~', $origin, $match)) {
            return rtrim($path, '/') . $match[0];
        }

        return $path;
    }
}
