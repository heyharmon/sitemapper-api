<?php

namespace DDD\Http\Base\Files;

use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use DDD\Domain\Base\Files\Resources\FileResource;
use DDD\Domain\Base\Files\Requests\UpdateFileRequest;
use DDD\Domain\Base\Files\Requests\StoreFileRequest;
use DDD\Domain\Base\Files\File;
use DDD\Domain\Base\Files\Actions\UpdateFileAction;
use DDD\Domain\Base\Files\Actions\StoreFileAction;
use DDD\App\Controllers\Controller;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $file = QueryBuilder::for(File::class)
            ->latest()
            ->get();

        return FileResource::collection($file);
    }

    public function store(StoreFileRequest $request)
    {
        $file = StoreFileAction::run($request->file, $request->folder);

        return new FileResource($file);
    }

    public function show(File $file)
    {
        return new FileResource($file);
    }

    public function update(File $file, UpdateFileRequest $request)
    {
        UpdateFileAction::run($file, $request->file);

        return new FileResource($file);
    }

    public function destroy(File $file): JsonResponse
    {
        $file->delete();

        Storage::delete($file->path);

        return response()->json(['message' => 'File destroyed'], 200);
    }
}
