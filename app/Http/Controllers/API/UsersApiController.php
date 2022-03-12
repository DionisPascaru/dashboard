<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UsersCollection;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersApiController extends BaseController
{

    /**
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return UsersCollection::collection(User::all());
    }

    /**
     * @param $id
     * @return JsonResource
     */
    public function show($id): JsonResource
    {
        $user = User::find($id);

        return new UserCollection($user);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $user = User::find($id);
        $user->delete();

        return $this->sendResponse(null, 'User ' . $user->name . ' successfully deleted.');
    }
}
