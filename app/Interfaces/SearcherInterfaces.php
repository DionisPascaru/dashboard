<?php

namespace App\Interfaces;

use Illuminate\Database\Query\Builder;

/**
 * Searcher interface.
 */
interface SearcherInterfaces
{
    /**
     * Search records.
     *
     * @param array $options
     * @return array
     */
    public function search(array $options): array;
}
