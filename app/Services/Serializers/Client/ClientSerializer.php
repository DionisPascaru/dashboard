<?php

namespace App\Services\Serializers\Client;

use App\Enums\Client\ClientFieldsEnum;

/**
 * Client serializer.
 */
class ClientSerializer
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
            ClientFieldsEnum::ID => $client[ClientFieldsEnum::ID],
            ClientFieldsEnum::NAME => $client[ClientFieldsEnum::NAME],
            ClientFieldsEnum::EMAIL => $client[ClientFieldsEnum::EMAIL],
            ClientFieldsEnum::CREATED_AT => $client[ClientFieldsEnum::CREATED_AT],
            ClientFieldsEnum::UPDATED_AT => $client[ClientFieldsEnum::UPDATED_AT],
            ClientFieldsEnum::STATUS => $client[ClientFieldsEnum::STATUS],
        ];
    }
}
