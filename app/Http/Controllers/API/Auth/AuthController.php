<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\RestResponseFactory;
use App\Http\Requests\Auth\UserLoginApiRequest;
use App\Http\Requests\Auth\UserRegisterApiRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Auth controller.
 */
class AuthController
{
    /** @var RestResponseFactory $restResponseFactory */
    private $restResponseFactory;

    /**
     * Construct.
     *
     * @param RestResponseFactory $restResponseFactory
     */
    public function __construct(RestResponseFactory $restResponseFactory)
    {
        $this->restResponseFactory = $restResponseFactory;
    }

    /**
     * Login.
     *
     * @param UserLoginApiRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginApiRequest $request): JsonResponse
    {
        try {
            Auth::attempt($request->validated());

            $authUser = Auth::user();
            $token =  $authUser->createToken('MyAuthApp')->plainTextToken;

            return $this->restResponseFactory->ok(
                [
                    'token' => $token,
                    'name' => $authUser->name
                ]
            );
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * Register.
     *
     * @param UserRegisterApiRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterApiRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();
            $input['password'] = bcrypt($input['password']);

            $user = User::create($input);
            $token =  $user->createToken('MyAuthApp')->plainTextToken;

            return $this->restResponseFactory->ok([
                'token' => $token,
                'name' => $user->name
            ]);
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * Get auth user.`
     *
     * @return JsonResponse
     */
    public function getAuthUser(): JsonResponse
    {
        try {
            $user = Auth::user();

            return $this->restResponseFactory->ok(
                [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role_id' => $user['role_id'],
                ]
            );
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception);
        }
    }
}
