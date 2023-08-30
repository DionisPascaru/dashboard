<?php

namespace App\Services\Supervisors;

use App\Models\Project;
use App\Models\ProjectImage;
use App\Traits\FileStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ProjectSupervisor
{
    use FileStorage;

    const TABLE_NAME = 'projects';

    /** @var DB $queryBuilder */
    private $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = DB::table(self::TABLE_NAME);
    }

    /**
     * Create a project.
     *
     * @param array $input
     *
     * @return Project
     */
    public function create(array $input): Project
    {
        $project = new Project();

        if (!empty($input['cover'])) {
            $input['cover'] = $this->store($input['cover'], 'publicFiles');
        }

        $newProject = $project->create($input);

        return $newProject;
    }

    /**
     * Update project.
     *
     * @param array $input
     * @return Project
     */
    public function update(array $input): Project
    {
        Project::where('id', $input['id'])->update($input);

        return Project::findOrFail($input['id']);
    }

    /**
     * Upload project file.
     *
     * @param array $input
     */
    public function fileUpdate(array $input): void
    {
        if (!empty($input['cover'])) {
            $input['cover'] = $this->store($input['cover'], 'publicFiles');
        }

        Project::findOrFail($input['id'])->update($input);
    }

    /**
     * Project image upload.
     *
     * @param int $projectId
     * @param UploadedFile $image
     */
    public function imageUpload(int $projectId, UploadedFile $image): void
    {
        $data = [
            'path' => $this->store($image, 'publicFiles'),
            'project_id' => $projectId
        ];

        $projectImage = new ProjectImage();
        $projectImage->insert($data);
    }

    public function removeImage(int $id): void
    {
        $projectImage = new ProjectImage();
        $projectImage->findOrFail($id)->delete();
    }
}
