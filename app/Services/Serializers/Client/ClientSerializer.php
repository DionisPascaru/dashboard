<?php

namespace App\Services\Serializers\Client;

use App\Enums\Client\ClientFieldsEnum;
use App\Enums\Client\ClientStatusEnum;

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
        $status = ClientStatusEnum::from($client[ClientFieldsEnum::STATUS]);

        return [
            ClientFieldsEnum::ID => $client[ClientFieldsEnum::ID],
            ClientFieldsEnum::NAME => $client[ClientFieldsEnum::NAME],
            ClientFieldsEnum::EMAIL => $client[ClientFieldsEnum::EMAIL],
            ClientFieldsEnum::STATUS => [
                'value' => $status->value,
                'name' => $status->name,
            ],
            ClientFieldsEnum::CREATED_AT => date('Y-m-d h:m:s', strtotime($client[ClientFieldsEnum::CREATED_AT])),
            ClientFieldsEnum::UPDATED_AT => date('Y-m-d h:m:s', strtotime($client[ClientFieldsEnum::UPDATED_AT])),
        ];
    }
}
