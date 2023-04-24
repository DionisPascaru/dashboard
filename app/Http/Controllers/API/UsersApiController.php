<?php

namespace App\Http\Controllers\API;

use App\Enums\UserRolesEnum;
use App\Http\Requests\UserCreateApiRequest;
use App\Http\Requests\UserUpdateApiRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UsersCollection;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UsersApiController
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
     * Read user by id.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $user = new UserCollection(User::findOrFail($id));

            return $this->restResponseFactory->ok($user);
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->badRequest($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

    /**
     * Create user
     *
     * @param UserCreateApiRequest $request
     * @return JsonResponse
     */
    public function create(UserCreateApiRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            $input['password'] = bcrypt($input['password']);
            $input['role_id'] = UserRolesEnum::EDITOR;

            $user = User::create($input);

            return $this->restResponseFactory->created(new UserCollection($user));
        } catch (ValidationException $exception) {
            return $this->restResponseFactory->badRequest($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

    /**
     * Update user.
     *
     * @param UserUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update(UserUpdateApiRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            User::where('id', $request['id'])->update($input);

            $user = User::findOrFail($request['id']);

            return $this->restResponseFactory->ok(new UserCollection($user));
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

    /**
     * Delete user.
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return $this->restResponseFactory->noContent();
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->badRequest($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }
}
