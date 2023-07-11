<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFile;
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

        $path = Storage::putFileAs('/', $file, $filename);
        $previewPath = null;

        if (explode('/', $file->getMimeType())[0] == 'image') {
            $previewPath = 'preview-' . $filename;

            $img = Image::make($file->getRealPath())
                ->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });

            Storage::disk('s3')->put('/' . $previewPath, $img->encode());
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

        return response($result, 201);
    }

    public function index()
    {
        return response([], 200);
    }
}
