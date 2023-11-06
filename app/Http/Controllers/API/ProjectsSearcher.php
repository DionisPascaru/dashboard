<?php

namespace App\Http\Controllers\API;

use App\Services\Serializers\ProjectSerializer;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ProjectsSearcher
{
    /** @var ProjectSerializer $projectSerializer */
    private $projectSerializer;

    /**
     * Constructor.
     *
     * @param ProjectSerializer $projectSerializer
     */
    public function __construct(
        ProjectSerializer $projectSerializer
    ) {
        $this->projectSerializer = $projectSerializer;
    }

    /**
     * Search query builder.
     *
     * @param array $options
     * @return array
     */
    public function search(array $options): array
    {
        $filters = $options['filters'] ?? [];
        $pageSize = $options['pageSize'] ?? 10;
        $pageNum = $options['pageNum'] ?? 1;

        $queryBuilder = $this->applyFilters($filters);

        $queryBuilder->paginate($pageSize, '*', 'page', $pageNum);
        $items = $queryBuilder
            ->select([
                'id',
                'title',
                'cover',
                'category_id',
                'created_at',
                'updated_at',
            ])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->toArray();
        $total = $queryBuilder->getCountForPagination();

        return [
            'items' => $this->projectSerializer->serializeForSearch($items),
            'total' => $total
        ];
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
