<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'new_password' => 'required|string|min:6|max:255|confirmed'
        ];
    }

    public function messages(): array
    {
        return [
            'new_password.required' => 'Password baru harus diisi',
            'new_password.string' => 'Password baru harus berupa string',
            'new_password.min' => 'Password baru minimal 6 karakter',
            'new_password.max' => 'Password baru maksimal 255 karakter',
            'new_password.confirmed' => 'Password baru tidak cocok dengan konfirmasi password',
        ];
    }
}
