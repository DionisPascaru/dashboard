<?php

namespace App\Http\Controllers\API\User;

use App\Enums\UserRolesEnum;
use App\Http\Controllers\API\RestResponseFactory;
use App\Http\Requests\User\UserCreateApiRequest;
use App\Http\Requests\User\UsersSearchRequest;
use App\Http\Requests\User\UserUpdateApiRequest;
use App\Services\Serializers\UserSerializer;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Psr\Log\LoggerInterface;

/**
 * Users API controller.
 */
class UsersApiController
{
    /** @var UsersSearcher $usersSearcher */
    private UsersSearcher $usersSearcher;

    /** @var UserSerializer $userSerialize */
    private UserSerializer $userSerialize;

    /** @var RestResponseFactory $restResponseFactory */
    private RestResponseFactory $restResponseFactory;

    /** @var LoggerInterface $logger */
    private LoggerInterface $logger;

    /**
     * Constructor.
     *
     * @param UsersSearcher $usersSearcher
     * @param UserSerializer $userSerialize
     * @param RestResponseFactory $restResponseFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        UsersSearcher $usersSearcher,
        UserSerializer $userSerialize,
        RestResponseFactory $restResponseFactory,
        LoggerInterface $logger
    ) {
        $this->usersSearcher = $usersSearcher;
        $this->userSerialize = $userSerialize;
        $this->restResponseFactory = $restResponseFactory;
        $this->logger = $logger;
    }

    /**
     * Search users.
     *
     * @param UsersSearchRequest $request
     *
     * @return JsonResponse
     */
    public function search(UsersSearchRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            $users = $this->usersSearcher->search($input);

            return $this->restResponseFactory->ok($users);
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

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
            $user = (array)DB::table('users')
                ->select('id', 'name', 'email', 'role_id')
                ->where('id', '=', $id)
                ->first();

            return $this->restResponseFactory->ok($this->userSerialize->serializeEntity($user));
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

            $table = DB::table('users');
            $userId = $table->insertGetId($input);
            $user = (array)DB::table('users as u')
                ->select('u.id', 'u.name', 'email', 'r.name as role')
                ->leftJoin('roles as r', 'u.role_id', '=', 'r.id')
                ->where('u.id', '=', $userId)
                ->first();

            return $this->restResponseFactory->created($this->userSerialize->serializeEntity($user));
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

            DB::table('users')
                ->where('id', '=', (int)$request['id'])
                ->update([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'role_id' => $input['role_id'],
                ]);

            return $this->restResponseFactory->ok();
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
            DB::table('users')
                ->delete($id);

            return $this->restResponseFactory->noContent();
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->badRequest($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }
}
