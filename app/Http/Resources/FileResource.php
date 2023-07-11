<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'size' => $this->size,
            'extension' => $this->extension,
            'previewPath' => $this->preview_path ? Storage::disk('s3')->url($this->preview_path) : null,
            'path' => Storage::disk('s3')->url($this->path),
        ];
    }
}
