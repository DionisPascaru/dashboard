<?php

namespace App\Services\Supervisors;

use App\Models\Project;
use App\Models\ProjectImage;
use App\Traits\FileStorage;

class ProjectSupervisor
{
    use FileStorage;

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

        if ($input['images']) {
            $this->insertProjectImages($input['images'], $newProject->id);
        }

        return $newProject;
    }

    /**
     * Insert project images.
     *
     * @param array $images
     * @param int $projectId
     *
     * @return void
     */
    private function insertProjectImages(array $images, int $projectId): void
    {
        $data = [];

        foreach ($images as $image) {
            $data[] = [
                'path' => $this->store($image, 'publicFiles'),
                'project_id' => $projectId
            ];
        }

        $projectImage = new ProjectImage();
        $projectImage->insert($data);
    }
}
