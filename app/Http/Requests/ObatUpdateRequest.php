<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObatUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'namaObat' => ['required', 'string', 'max:255'],
            'kemasan' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric'],
        ];
    }
}
