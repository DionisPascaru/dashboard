<?php

namespace App\Services\Serializers;

/**
 * Project serializer.
 */
class ProjectSerializer
{
    /**
     * Serialize project.
     *
     * @param array $input
     * @return array
     */
    public function serialize(array $input): array
    {
        $cover = $input['cover'] ? [
            'name' => $input['cover'],
            'url' => config('filesystems.disks.backend.path') . $input['cover'],
        ] : null;

        $images = array_map(function ($image) {
            return [
                'id' => $image->id,
                'name' => $image->path,
                'url' => config('filesystems.disks.backend.path') . $image->path,
            ];
        }, $input['images']);

        return [
            'id' => $input['id'],
            'title' => $input['title'],
            'cover' => $cover,
            'category_id' => $input['category_id'],
            'images' => $images,
        ];
    }
}
