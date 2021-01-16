<?php

namespace Sulao\LRTS\Pagination;

use Sulao\LRTS\Helper;

class LengthAwarePaginator extends \Illuminate\Pagination\LengthAwarePaginator
{
    /**
     * Create a new paginator instance.
     *
     * @param mixed    $items
     * @param int      $total
     * @param int      $perPage
     * @param int|null $currentPage
     * @param array    $options     (path, query, fragment, pageName)
     *
     * @return void
     */
    public function __construct(
        $items,
        $total,
        $perPage,
        $currentPage = null,
        array $options = []
    ) {
        parent::__construct($items, $total, $perPage, $currentPage, $options);

        if (isset($options['path'])) {
            $this->path = Helper::appendSlashes(
                $this->path,
                $options['path']
            );
        }
    }
}
