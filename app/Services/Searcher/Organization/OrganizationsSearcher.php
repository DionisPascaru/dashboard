<?php

namespace App\Services\Searcher\Organization;

use App\Enums\Organization\OrganizationFieldsEnum;
use App\Enums\Organization\OrganizationFiltersEnum;
use App\Models\Organization;
use App\Services\Serializers\Organization\OrganizationSerializer;
use Illuminate\Database\Eloquent\Builder;

/**
 * Organization searcher.
 */
class OrganizationsSearcher
{
    /**
     * Constructor.
     *
     * @param OrganizationSerializer $organizationSerializer
     */
    public function __construct(private readonly OrganizationSerializer $organizationSerializer)
    {
    }

    /**
     * Search organizations.
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
                OrganizationFieldsEnum::ID,
                OrganizationFieldsEnum::NAME,
                OrganizationFieldsEnum::EMAIL,
                OrganizationFieldsEnum::CREATED_AT,
                OrganizationFieldsEnum::UPDATED_AT,
            ])
            ->orderBy(OrganizationFieldsEnum::CREATED_AT, 'desc')
            ->get()
            ->toArray();
        $total = $queryBuilder->paginate()->total();

        return [
            'items' => \array_map(function ($item) {
                return $this->organizationSerializer->serializeForSearch($item);
            }, $items),
            'total' => $total
        ];
    }

    /**
     * Apply filters.
     *
     * @param array $filters
     *
     * @return Builder
     */
    private function applyFilters(array $filters): Builder
    {
        $queryBuilder = Organization::query();

        if (!empty($filters[OrganizationFiltersEnum::NAME])) {
            $queryBuilder->where('name', 'like', '%' . $filters[OrganizationFiltersEnum::NAME] . '%');
        }
        if (!empty($filters[OrganizationFiltersEnum::EMAIL])) {
            $queryBuilder->where('email', 'like', '%' . $filters[OrganizationFiltersEnum::EMAIL] . '%');
        }
        if (!empty($filters[OrganizationFiltersEnum::DATE_FROM])) {
            $queryBuilder->whereDate('created_at', '>=', $filters[OrganizationFiltersEnum::DATE_FROM
            ]);
        }
        if (!empty($filters[OrganizationFiltersEnum::DATE_TILL])) {
            $queryBuilder->whereDate('created_at', '<=', $filters[OrganizationFiltersEnum::DATE_TILL]);
        }

        return $queryBuilder;
    }
}
