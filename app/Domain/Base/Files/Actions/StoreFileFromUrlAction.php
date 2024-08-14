<?php

namespace DDD\Domain\Base\Files\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DDD\Domain\Base\Organizations\Organization;
use DDD\Domain\Base\Files\File;

class StoreFileFromUrlAction
{
    use AsAction;
    
    function handle(String $url, String $folder = 'public', String $extension = 'png')
    {
        $disk = config('filesystems.default');
        
        $name = basename($url) . '.' . $extension;

        try {
            Storage::put($folder . '/' . $name, file_get_contents($url));

            $path = Storage::path($folder . '/' . $name);

            $file = File::updateOrCreate(
                [
                    'path' => $path
                ],
                [
                    'path' => $path,
                    'name' => $name,
                    'filename' => basename($path),
                    'extension' => $extension,
                    'disk' => $disk,
                ]
            );

            return $file;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}