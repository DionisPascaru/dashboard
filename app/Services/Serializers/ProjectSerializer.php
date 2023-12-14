<?php

namespace App\Services\Serializers;

use Illuminate\Support\Facades\DB;

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

    /**
     * Serialize for search.
     *
     * @param array $items
     * @return array
     */
    public function serializeForSearch(array $items): array
    {
        return array_map(function ($item) {
            $cover = [
                'url' => $item->cover
                    ? config('filesystems.disks.backend.path') . $item->cover
                    : null,
            ];

            return [
                'id' => $item->id,
                'title' => $item->title,
                'cover' => $cover,
                'category' => DB::table('project_categories')
                    ->where('id', '=', $item->category_id)
                    ->value('name'),
                'created' => date('Y-m-d', strtotime($item->created_at)),
                'updated' => date('Y-m-d', strtotime($item->updated_at)),
            ];
        }, $items);
    }
}
