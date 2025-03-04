<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicalPrescriptionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_inspection' => ['required', 'exists:inspections,id_inspection'],
            'id_obat' => ['required', 'string', 'max:255'],
            'nama_obat' => ['required', 'string', 'max:255'],
            'jumlah' => ['required', 'integer', 'min:0'], 
        ];
    }
}
