<?php

namespace App\Http\Controllers\API;

use App\Models\ProjectCategory;
use Exception;
use Illuminate\Http\JsonResponse;

class ProjectCategoriesApiController
{
    /** @var RestResponseFactory $restResponseFactory */
    private $restResponseFactory;

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
