<?php

namespace App\Http\Controllers\API;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ProjectsSearcher
{
    /**
     * Search query builder.
     *
     * @param array $options
     * @return array
     */
    public function search(array $options): array
    {
        ['filters' => $filters, 'pageSize' => $pageSize, 'pageNum' => $pageNum] = $options;

        $queryBuilder = $this->applyFilters($filters);
        $queryBuilder->paginate($pageSize, '*', 'page', $pageNum);

        return $queryBuilder->get()->toArray();
    }

    /**
     * Apply filters for search.
     *
     * @param array $filters
     * @return Builder
     */
    private function applyFilters(array $filters): Builder
    {
        $queryBuilder = DB::table('projects');

        if (!empty($filters['title'])) {
            $queryBuilder->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $queryBuilder->where('category_id', '=', $filters['category_id']);
        }

        return $queryBuilder;
    }
}
