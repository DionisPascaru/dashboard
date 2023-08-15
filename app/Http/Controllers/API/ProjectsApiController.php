<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ProjectCreateApiRequest;
use App\Http\Requests\ProjectFileUploadRequest;
use App\Http\Requests\ProjectUpdateApiRequest;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectImage;
use App\Services\Supervisors\ProjectSupervisor;
use App\Traits\FileStorage;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProjectsApiController
{
    use FileStorage;

    /** @var ProjectSupervisor $projectSupervisor */
    private $projectSupervisor;

    /** @var RestResponseFactory $restResponseFactory */
    private $restResponseFactory;

    /**
     * @param ProjectSupervisor $projectSupervisor
     * @param RestResponseFactory $restResponseFactory
     */
    public function __construct(
        ProjectSupervisor $projectSupervisor,
        RestResponseFactory $restResponseFactory
    )
    {
        $this->projectSupervisor = $projectSupervisor;
        $this->restResponseFactory = $restResponseFactory;
    }

    /**
     * Read all projects.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $projects = array_map(function ($project) {
                return [
                    'id' => $project['id'],
                    'title' => $project['title'],
                    'cover' => $project['cover'],
                    'category' => $this->processProjectCategory($project['category_id']),
                    'video' => $project['video'],
                    'created_at' => $project['created_at'],
                    'updated_at' => $project['updated_at'],
                ];
            }, Project::all()->toArray());

            return $this->restResponseFactory->ok($projects);
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception);
        }
    }


    /**
     * Read a project.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);

            $project['images'] = ProjectImage::where('project_id', $id)->get('path');

            return $this->restResponseFactory->ok($project);
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->badRequest($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception);
        }
    }

    /**
     * Creat a project.
     *
     * @param ProjectCreateApiRequest $request
     * @return JsonResponse
     */
    public function create(ProjectCreateApiRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();
            $input['cover'] = $request->file('cover');
            $input['images'] = $request->file('images');

            return $this->restResponseFactory->created($this->projectSupervisor->create($input));
        } catch (ValidationException $exception) {
            return $this->restResponseFactory->badRequest($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

    /**
     * Update a project.
     *
     * @param ProjectUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update(ProjectUpdateApiRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            return $this->restResponseFactory->ok(
                $this->projectSupervisor->update($input)
            );
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

    /**
     * Delete project.
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            return $this->restResponseFactory->noContent();
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->badRequest($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

    /**
     * Process project category.
     *
     * @param int $categoryId
     *
     * @return ProjectCategory
     */
    private function processProjectCategory(int $categoryId): ProjectCategory
    {
        return ProjectCategory::findOrFail($categoryId);
    }
}
