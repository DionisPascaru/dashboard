<?php

namespace App\Services\Serializers;

/**
 * User serializer.
 */
class UserSerializer
{
    /**
     * Serialize users.
     *
     * @param array $input
     * @return array
     */
    public function serializeEntities(array $input): array
    {
        return array_map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ];
        }, $input);
    }

    /**
     * Serialize user.
     *
     * @param array $user
     * @return array
     */
    public function serializeEntity(array $user): array
    {
        return [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
    }
}
