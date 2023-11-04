<?php

namespace App\Services\Supervisors;

use App\Traits\FileStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ProjectSupervisor
{
    use FileStorage;

    /**
     * Read projects.
     *
     * @return array
     */
    public function read(): array
    {
        return DB::table('projects as p')
            ->select(
                'p.id',
                'title',
                'cover',
                'pc.name as category',
                'p.created_at as created',
                'p.updated_at as updated'
            )
            ->leftJoin('project_categories as pc', 'p.category_id', '=', 'pc.id')
            ->get()
            ->toArray();
    }

    /**
     * Show project by id.
     *
     * @param $id
     * @return array
     */
    public function show($id): array
    {
        $project = (array)DB::table('projects')
            ->select(
                'id',
                'title',
                'cover',
                'category_id',
            )
            ->where('id', '=', $id)
            ->first();

        $project['images'] = DB::table('project_images')
            ->select()
            ->where('project_id', '=', $id)
            ->get()
            ->toArray();

        return $project;
    }

    /**
     * Create a project.
     *
     * @param array $input
     *
     * @return array
     */
    public function create(array $input): array
    {
        if (!empty($input['cover'])) {
            $input['cover'] = $this->store($input['cover'], 'publicFiles');
        }

        DB::table('projects')->insert($input);

        return [
            'message' => 'Project successfully created.'
        ];
    }

    /**
     * Update project.
     *
     * @param array $input
     * @return array
     */
    public function update(array $input): array
    {
        DB::table('projects')
            ->where('id', '=', $input['id'])
            ->update($input);

        return [
            'message' => 'Project successfully updated.'
        ];
    }

    /**
     * Delete project.
     *
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        DB::table('projects')
            ->where('id', '=', $id)
            ->delete();

        return [
            'message' => 'Project successfully deleted.'
        ];
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

        DB::table('projects')
            ->where('id', '=', $input['id'])
            ->update($input);
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

        DB::table('project_images')
            ->insert($data);
    }

    /**
     * Project image remove.
     *
     * @param int $id
     */
    public function removeImage(int $id): void
    {
        DB::table('project_images')
            ->where('id', '=', $id)
            ->delete();
    }
}
