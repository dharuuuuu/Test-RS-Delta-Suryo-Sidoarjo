<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_inspection' => ['required', 'exists:inspections,id_inspection'], // foreign key
            'file_url' => ['required', 'string'], // longText
        ];
    }
}
