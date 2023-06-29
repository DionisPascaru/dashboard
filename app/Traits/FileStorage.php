<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

/**
 * File manager.
 */
trait FileStorage
{
    /**
     * @param UploadedFile $file
     * @param string $folder
     * @param string $disk
     *
     * @return string
     */
    public function store(UploadedFile $file, string $folder, string $disk = 'backend'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->storeAs($folder, $filename, ['disk' => $disk]);

        return $filename;
    }
}
