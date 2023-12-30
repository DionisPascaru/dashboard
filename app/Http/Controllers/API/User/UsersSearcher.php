<?php

namespace App\Http\Controllers\API\User;

use App\Interfaces\SearcherInterfaces;
use App\Services\Serializers\UserSerializer;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class UsersSearcher implements SearcherInterfaces
{
    /** @var UserSerializer $userSerializer */
    private UserSerializer $userSerializer;

    /**
     * Constructor.
     *
     * @param UserSerializer $userSerializer
     */
    public function __construct(UserSerializer $userSerializer) {
        $this->userSerializer = $userSerializer;
    }

    /**
     * Search users.
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
                'name',
                'email',
                'role_id',
                'created_at',
            ])
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        $total = $queryBuilder->getCountForPagination();

        return [
            'items' => $this->userSerializer->serializeForSearch($items),
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
        $queryBuilder = DB::table('users');

        if (!empty($filters['name'])) {
            $queryBuilder->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['email'])) {
            $queryBuilder->where('email', 'like', '%' . $filters['email'] . '%');
        }

        if (!empty($filters['role_id'])) {
            $queryBuilder->where('role_id', '=', $filters['role_id']);
        }

        if (!empty($filters['date_from'])) {
            $queryBuilder->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_till'])) {
            $queryBuilder->whereDate('created_at', '<=', $filters['date_till']);
        }

        return $queryBuilder;
    }
}
