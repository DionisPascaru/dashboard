<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\RestResponseFactory;
use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Roles api controller.
 */
class RolesApiController
{
    /** @var RestResponseFactory $restResponseFactory */
    private RestResponseFactory $restResponseFactory;

    /**
     * Constructor.
     *
     * @param RestResponseFactory $restResponseFactory
     */
    public function __construct(RestResponseFactory $restResponseFactory)
    {
        $this->restResponseFactory = $restResponseFactory;
    }

    /**
     * Read all project categories.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return $this->restResponseFactory->ok(Role::all());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception);
        }
    }
}
