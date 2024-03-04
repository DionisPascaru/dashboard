<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Controllers\API\RestResponseFactory;
use App\Http\Requests\Project\ProjectCategoryCreateApiRequest;
use App\Models\ProjectCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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

    public function create(ProjectCategoryCreateApiRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            DB::table('project_categories')->insert($input);

            return $this->restResponseFactory->created(
                [
                    'message' => 'Project successfully created.'
                ]
            );
        } catch (ValidationException $exception) {
            return $this->restResponseFactory->badRequest($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }
}
