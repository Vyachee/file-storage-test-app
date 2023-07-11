<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFile;
use App\Http\Requests\DeleteFile;
use App\Http\Requests\SearchFile;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FilesController extends Controller
{
    public function store(CreateFile $request)
    {
        $data = $request->validated();

        $file = $request->file('file');
        $uuid = Str::uuid();
        $filename = $uuid . '.' . $file->extension();

        $path = Storage::putFileAs('/', $file, $filename, 'public');
        $previewPath = null;

        if (explode('/', $file->getMimeType())[0] == 'image') {
            $previewPath = 'preview-' . $filename;

            $img = Image::make($file->getRealPath())
                ->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });

            Storage::disk('s3')->put('/' . $previewPath, $img->encode(), 'public');
        }

        $fileSize = $file->getSize() / 1000000;
        $extension = $file->extension();
        $title = $data['title'] ?? str_replace(
            '.' . $file->getClientOriginalExtension(),'', $file->getClientOriginalName()
        );

        $result = File::query()->create([
            'title' => $title,
            'size' => $fileSize,
            'extension' => $extension,
            'path' => $path,
            'preview_path' => $previewPath
        ]);

        return response(FileResource::make($result), 201);
    }

    public function index(SearchFile $request)
    {
        $data = $request->validated();
        $files = File::query();

        if(isset($data['query'])) {
            $files->where('title', 'ilike', '%'. $data['query'] .'%');
        }

        $files = $files->paginate(50);

        return response(FileResource::collection($files), 200);
    }

    public function destroy(DeleteFile $request)
    {
        $file = File::query()->find($request['file']);
        $paths = [];

        if(isset($file['preview_path'])) $paths[] = $file['preview_path'];
        if(isset($file['path'])) $paths[] = $file['path'];

        Storage::delete($paths);
        $file->delete();

        return response([
            'success' => true
        ]);
    }
}
