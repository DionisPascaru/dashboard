<?php

namespace App\Services\Supervisors\Client;

use App\Enums\Client\ClientFieldsEnum;
use App\Enums\Client\ClientStatusEnum;
use App\Enums\Organization\OrganizationFieldsEnum;
use App\Models\Client;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;

/**
 * Client supervisor.
 */
class ClientSupervisor
{
    /**
     * Create.
     *
     * @param array $input
     *
     * @return array
     */
    public function create(array $input): array
    {
        $client = new Client();
        $client->name = $input[ClientFieldsEnum::NAME];
        $client->email = $input[ClientFieldsEnum::EMAIL];
        $client->password = Hash::make($input[ClientFieldsEnum::PASSWORD]);
        $client->save();

        return ['id' => $client->id];
    }

    /**
     * Update.
     *
     * @param Client $client
     * @param array $input
     *
     * @return array
     */
    public function update(Client $client, array $input): array
    {
        $client->name = $input[ClientFieldsEnum::NAME];
        $client->email = $input[ClientFieldsEnum::EMAIL];
        $client->save();

        return [
            ClientFieldsEnum::ID => $client->id,
            ClientFieldsEnum::NAME => $client->name,
            ClientFieldsEnum::EMAIL => $client->email,
        ];
    }

    /**
     * Read.
     *
     * @param Client $client
     *
     * @return array
     */
    public function read(Client $client): array
    {
        $status = ClientStatusEnum::from($client[ClientFieldsEnum::STATUS]);

        return [
            ClientFieldsEnum::ID => $client[ClientFieldsEnum::ID],
            ClientFieldsEnum::NAME => $client[ClientFieldsEnum::NAME],
            ClientFieldsEnum::EMAIL => $client[ClientFieldsEnum::EMAIL],
            ClientFieldsEnum::PHONE => $client[ClientFieldsEnum::PHONE],
            ClientFieldsEnum::STATUS => [
                'value' => $status->value,
                'name' => $status->name,
            ],
            ClientFieldsEnum::CREATED_AT => date('Y-m-d h:m:s', strtotime($client[ClientFieldsEnum::CREATED_AT])),
            ClientFieldsEnum::UPDATED_AT => date('Y-m-d h:m:s', strtotime($client[ClientFieldsEnum::UPDATED_AT])),
        ];
    }

    /**
     * Delete.
     *
     * @param Client $client
     */
    public function delete(Client $client): void
    {
        $client->delete();
    }

    /**
     * Read organizations.
     *
     * @param Client $client
     *
     * @return array
     */
    public function readOrganizations(Client $client): array
    {
        return $client->organizations
            ->map(function ($organization) {
                return [
                    'id' => $organization->id,
                    'owner' => $organization->owner->name,
                    'name' => $organization->name,
                    'description' => $organization->description,
                    'address' => $organization->address,
                    'phone' => $organization->phone,
                    'email' => $organization->email,
                ];
            })
            ->toArray();
    }
}
