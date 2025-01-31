<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InspectionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_pasien' => ['required', 'string', 'max:255'],
            'tinggi_badan' => ['required', 'numeric'], // decimal(10,2)
            'berat_badan' => ['required', 'numeric'], // decimal(10,2)
            'systole' => ['required', 'string', 'max:10'], // string
            'diastole' => ['required', 'string', 'max:10'], // string
            'heart_rate' => ['required', 'string', 'max:10'], // string
            'respiration_rate' => ['required', 'string', 'max:10'], // string
            'suhu_tubuh' => ['required', 'numeric'], // decimal(10,2)
            'hasil_pemeriksaan' => ['required', 'string'], // longText
            'status' => ['required', 'string', 'max:50'], // string
            'tanggal_pemeriksaan' => ['required', 'date'],
            'file_url' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10000',
        ];
    }
}
