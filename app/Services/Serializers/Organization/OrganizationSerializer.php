<?php

namespace App\Services\Serializers\Organization;

use App\Enums\Organization\OrganizationFieldsEnum;

/**
 * Organization serializer.
 */
class OrganizationSerializer
{
    /**
     * Serialize client for search.
     *
     * @param array $client
     *
     * @return array
     */
    public function serializeForSearch(array $client): array
    {
        return [
            OrganizationFieldsEnum::ID => $client[OrganizationFieldsEnum::ID],
            OrganizationFieldsEnum::NAME => $client[OrganizationFieldsEnum::NAME],
            OrganizationFieldsEnum::EMAIL => $client[OrganizationFieldsEnum::EMAIL],
            OrganizationFieldsEnum::CREATED_AT => date('Y-m-d h:m:s', strtotime($client[OrganizationFieldsEnum::CREATED_AT])),
            OrganizationFieldsEnum::UPDATED_AT => date('Y-m-d h:m:s', strtotime($client[OrganizationFieldsEnum::UPDATED_AT])),
        ];
    }
}
