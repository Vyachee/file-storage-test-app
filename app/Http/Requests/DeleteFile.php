<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFile extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'exists:files,id'
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['file' => $this->route('file')]);
    }
}
