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
    public static function appendSlashes($path, $origin)
    {
        if ($path !== $origin) {
            $slash = self::getTrailingSlashes($origin);
            return rtrim($path, '/') . $slash;
        }

        return $path;
    }

    /**
     * Get trailing slashes
     *
     * @param string $path
     *
     * @return string
     */
    public static function getTrailingSlashes($path)
    {
        $slash = '';
        $offset = -1;
        $len = strlen($path);
        while ($len >= abs($offset) && substr($path, $offset, 1) === '/') {
            $slash .= '/';
            $offset -= 1;
        }

        return $slash;
    }
}
