<?php

namespace DDD\Domain\Base\Files\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Storage;
use DDD\Domain\Base\Files\File;

class UpdateFileAction
{
    use AsAction;
    
    function handle(File $file, $updatedFile)
    {
        
        $disk = config('filesystems.default');
        
        // Store new file in storage
        $newPath = $updatedFile->store($file->folder, $disk);

        // Remove old file storage
        Storage::disk($disk)->delete($file->path);
        
        // Update file
        $file->update([
            'path' => $newPath,
            'name' => pathinfo($updatedFile->getClientOriginalName(), PATHINFO_FILENAME),
            'filename' => basename($newPath),
            'extension' => $updatedFile->getClientOriginalExtension(),
            'disk' => $disk,
            'folder' => $updatedFile->folder
        ]);

        return $file;
    }
}