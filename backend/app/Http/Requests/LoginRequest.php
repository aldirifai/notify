<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ];
    }

//    custom message
    public function messages(): array
    {
        return [
            'username.required' => 'Username harus diisi',
            'username.string' => 'Username harus berupa string',
            'username.max' => 'Username maksimal 255 karakter',
            'password.required' => 'Password harus diisi',
            'password.string' => 'Password harus berupa string',
            'password.min' => 'Password minimal 6 karakter',
            'password.max' => 'Password maksimal 255 karakter',
        ];
    }
}
