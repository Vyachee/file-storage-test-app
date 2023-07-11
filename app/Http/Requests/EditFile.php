<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditFile extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attachment' => [
                'required',
                'file',
                'max:8000'
            ],
            'title' => 'nullable',
            'id' => [
                'required',
                'exists:files,id'
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('id')]);
    }
}
