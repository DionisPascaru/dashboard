<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Controllers\API\RestResponseFactory;
use App\Http\Requests\Project\ProjectCreateApiRequest;
use App\Http\Requests\Project\ProjectFileUploadApiRequest;
use App\Http\Requests\Project\ProjectImageUploadApiRequest;
use App\Http\Requests\Project\ProjectsSearchRequest;
use App\Http\Requests\Project\ProjectUpdateApiRequest;
use App\Services\Serializers\ProjectSerializer;
use App\Services\Supervisors\ProjectSupervisor;
use App\Traits\FileStorage;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProjectsApiController
{
    use FileStorage;

    /** @var ProjectsSearcher $projectsSearcher */
    private $projectsSearcher;

    /** @var ProjectSupervisor $projectSupervisor */
    private $projectSupervisor;

    /** @var ProjectSerializer $projectSerializer */
    private $projectSerializer;

    /** @var RestResponseFactory $restResponseFactory */
    private $restResponseFactory;

    /**
     * @param ProjectSupervisor $projectSupervisor
     * @param ProjectSerializer $projectSerializer
     * @param RestResponseFactory $restResponseFactory
     */
    public function __construct(
        ProjectsSearcher    $projectsSearcher,
        ProjectSupervisor   $projectSupervisor,
        ProjectSerializer   $projectSerializer,
        RestResponseFactory $restResponseFactory
    )
    {
        $this->projectsSearcher = $projectsSearcher;
        $this->projectSupervisor = $projectSupervisor;
        $this->projectSerializer = $projectSerializer;
        $this->restResponseFactory = $restResponseFactory;
    }

    /**
     * Search projects.
     *
     * @param ProjectsSearchRequest $request
     * @return JsonResponse
     */
    public function search(ProjectsSearchRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            $projects = $this->projectsSearcher->search($input);

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
            $project = $this->projectSupervisor->show($id);

            return $this->restResponseFactory->ok(
                $this->projectSerializer->serialize($project)
            );
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
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->notFound($exception->getMessage());
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
            $this->projectSupervisor->delete($id);

            return $this->restResponseFactory->noContent();
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->notFound($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

    /**
     * Project file upload.
     *
     * @param ProjectFileUploadApiRequest $request
     * @return JsonResponse
     */
    public function fileUpload(ProjectFileUploadApiRequest $request): JsonResponse
    {
        try {
            $input = $request->validated();

            $input['cover'] = $request->file('cover');
            $this->projectSupervisor->fileUpdate($input);

            return $this->restResponseFactory->ok();
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->notFound($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

    /**
     * Image upload.
     *
     * @param ProjectImageUploadApiRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function imageUpload(ProjectImageUploadApiRequest $request, $id): JsonResponse
    {
        try {
            $input = $request->validated();
            $input['image'] = $request->file('image');

            $this->projectSupervisor->imageUpload($id, $input['image']);

            return $this->restResponseFactory->ok();
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->notFound($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

    /**
     * Image remove.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function imageRemove(int $id): JsonResponse
    {
        try {
            $this->projectSupervisor->removeImage($id);

            return $this->restResponseFactory->ok();
        } catch (ModelNotFoundException $exception) {
            return $this->restResponseFactory->notFound($exception->getMessage());
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }
}
