<?php

namespace Sulao\LRTS\Pagination;

use Sulao\LRTS\Helper;

class Paginator extends \Illuminate\Pagination\Paginator
{
    /**
     * Create a new paginator instance.
     *
     * @param mixed    $items
     * @param int      $perPage
     * @param int|null $currentPage
     * @param array    $options     (path, query, fragment, pageName)
     *
     * @return void
     */
    public function __construct(
        $items,
        $perPage,
        $currentPage = null,
        array $options = []
    ) {
        parent::__construct($items, $perPage, $currentPage, $options);

        if (isset($options['path'])) {
            $this->path = Helper::appendTrailingSlashes(
                $this->path,
                $options['path']
            );
        }
    }
}
