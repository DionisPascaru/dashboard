<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Controllers\API\RestResponseFactory;
use App\Models\ProjectCategory;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * project categories api controller.
 */
class ProjectCategoriesApiController
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
            return $this->restResponseFactory->ok(ProjectCategory::all());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception);
        }
    }
}
