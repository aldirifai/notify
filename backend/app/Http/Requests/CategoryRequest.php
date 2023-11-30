<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->user()->role === 'admin') {
            return [
                'name' => 'required|string|max:255',
                'created_by' => 'required|exists:users,id'
            ];
        }

        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 255 karakter',
            'created_by.required' => 'Pembuat harus diisi',
            'created_by.exists' => 'Pembuat tidak ditemukan'
        ];
    }
}
