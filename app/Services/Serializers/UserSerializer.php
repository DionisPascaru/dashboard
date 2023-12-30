<?php

namespace App\Services\Serializers;

use http\Client\Curl\User;
use Illuminate\Support\Facades\DB;

/**
 * User serializer.
 */
class UserSerializer
{
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
            'role_id' => $user['role_id'],
        ];
    }

    /**
     * Serialize user for search.
     *
     * @param array $user
     * @return array
     */
    public function serializeForSearch(array $users): array
    {
        return array_map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => DB::table('roles')
                    ->where('id', '=', $user->role_id)
                    ->value('name'),
                'created' => date('Y-m-d', strtotime($user->created_at)),
            ];
        }, $users);
    }
}
