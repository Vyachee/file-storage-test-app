<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFile extends FormRequest
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
                'file',
                'max:8000'
            ],
            'title' => 'nullable'
        ];
    }
}
