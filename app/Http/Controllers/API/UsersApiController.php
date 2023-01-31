<?php

namespace App\Http\Controllers\API;

use App\Enums\UserRolesEnum;
use App\Http\Requests\UserCreateApiRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UsersCollection;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersApiController extends BaseController
{
    /** @var RestResponseFactory $restResponseFactory */
    private $restResponseFactory;

    public function __construct(RestResponseFactory $restResponseFactory)
    {
        $this->restResponseFactory = $restResponseFactory;
    }

    /**
     * Read all users.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return $this->restResponseFactory->ok(UsersCollection::collection(User::all()));
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $user = new UserCollection(User::findOrFail($id));

            return $this->restResponseFactory->ok($user);
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->notFound($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

    public function create(UserCreateApiRequest $request): JsonResource
    {
        $input = $request->validated();

        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = UserRolesEnum::TEACHER;

        $user = User::create($input);

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
