<?php

namespace App\Http\Controllers\API;

use App\Enums\UserRolesEnum;
use App\Http\Requests\UserCreateApiRequest;
use App\Http\Requests\UserUpdateApiRequest;
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
    /** @var UserSerializer $userSerialize */
    private $userSerialize;

    /** @var RestResponseFactory $restResponseFactory */
    private $restResponseFactory;

    /** @var LoggerInterface $logger */
    private $logger;

    /**
     * Constructor.
     *
     * @param UserSerializer $userSerialize
     * @param RestResponseFactory $restResponseFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        UserSerializer $userSerialize,
        RestResponseFactory $restResponseFactory,
        LoggerInterface $logger
    ) {
        $this->userSerialize = $userSerialize;
        $this->restResponseFactory = $restResponseFactory;
        $this->logger = $logger;
    }

    /**
     * Read all users.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $users = DB::table('users as u')
                ->select('u.id', 'u.name', 'email', 'r.name as role')
                ->leftJoin('roles as r', 'u.role_id', '=', 'r.id')
                ->get()
                ->toArray();

            return $this->restResponseFactory->ok($this->userSerialize->serializeEntities($users));
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
            $user = (array)DB::table('users as u')
                ->select('u.id', 'u.name', 'email', 'r.name as role')
                ->leftJoin('roles as r', 'u.role_id', '=', 'r.id')
                ->where('u.id', '=', $id)
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
