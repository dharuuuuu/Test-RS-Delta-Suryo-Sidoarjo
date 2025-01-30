<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_inspection' => ['required', 'exists:inspections,id_inspection'], // foreign key
            'total_harga' => ['required', 'integer', 'min:0'], // integer
            'total_bayar' => ['required', 'integer', 'min:0'], // integer
            'total_dibayar' => ['required', 'integer', 'min:0'], // integer
            'total_kembalian' => ['required', 'integer', 'gte:0'], // integer
        ];
    }
}
