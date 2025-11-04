<?php

namespace App\Services\Searcher\Clients;

use App\Enums\Client\ClientFieldsEnum;
use App\Enums\Client\ClientFiltersEnum;
use App\Models\Client;
use App\Services\Serializers\Client\ClientSerializer;
use Illuminate\Database\Eloquent\Builder;

class ClientsSearcher
{
    /** @var ClientSerializer $clientSerializer */
    private ClientSerializer $clientSerializer;

    /**
     * Constructor.
     *
     * @param ClientSerializer $clientSerializer
     */
    public function __construct(ClientSerializer $clientSerializer) {
        $this->clientSerializer = $clientSerializer;
    }

    /**
     * Search clients.
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
                ClientFieldsEnum::ID,
                ClientFieldsEnum::NAME,
                ClientFieldsEnum::EMAIL,
                ClientFieldsEnum::CREATED_AT,
                ClientFieldsEnum::UPDATED_AT,
                ClientFieldsEnum::STATUS,
            ])
            ->orderBy(ClientFieldsEnum::CREATED_AT, 'desc')
            ->get()
            ->toArray();
        $total = $queryBuilder->paginate()->total();

        return [
            'items' => \array_map(function ($item) {
                return $this->clientSerializer->serializeForSearch($item);
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
        $queryBuilder = Client::query();

        if (!empty($filters[ClientFiltersEnum::NAME])) {
            $queryBuilder->where('name', 'like', '%' . $filters[ClientFiltersEnum::NAME] . '%');
        }
        if (!empty($filters[ClientFiltersEnum::EMAIL])) {
            $queryBuilder->where('email', 'like', '%' . $filters[ClientFiltersEnum::EMAIL] . '%');
        }
        if (!empty($filters[ClientFiltersEnum::DATE_FROM])) {
            $queryBuilder->whereDate('created_at', '>=', $filters[ClientFiltersEnum::DATE_FROM
            ]);
        }
        if (!empty($filters[ClientFiltersEnum::DATE_TILL])) {
            $queryBuilder->whereDate('created_at', '<=', $filters[ClientFiltersEnum::DATE_TILL]);
        }

        return $queryBuilder;
    }
}
