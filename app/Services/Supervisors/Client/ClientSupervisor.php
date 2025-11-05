<?php

namespace App\Services\Supervisors\Client;

use App\Enums\Client\ClientFieldsEnum;
use App\Models\Client;
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
        return [
            ClientFieldsEnum::ID => $client->id,
            ClientFieldsEnum::NAME => $client->name,
            ClientFieldsEnum::EMAIL => $client->email,
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
}
