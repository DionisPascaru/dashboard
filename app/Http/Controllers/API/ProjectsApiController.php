<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ProjectCreateApiRequest;
use App\Http\Requests\ProjectUpdateApiRequest;
use App\Models\Project;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProjectsApiController
{
    /** @var RestResponseFactory $restResponseFactory */
    private $restResponseFactory;

    public function __construct(RestResponseFactory $restResponseFactory)
    {
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
            return $this->restResponseFactory->ok(Project::all());
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

             $file = $request->file('cover');
             $extension = $file->getClientOriginalExtension();
             $filename = time() . '.' . $extension;
             $file->move('files/images', $filename);
             $input['cover'] = $filename;

             $project = Project::create($input);

            return $this->restResponseFactory->created($project);
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

            Project::where('id', $request['id'])->update($input);

            $project = Project::findOrFail($request['id']);

            return $this->restResponseFactory->ok($project);
        } catch (Exception $exception) {
            return $this->restResponseFactory->serverError($exception->getMessage());
        }
    }

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
}
