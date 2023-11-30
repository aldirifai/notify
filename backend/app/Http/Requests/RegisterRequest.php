<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'phone' => 'required|numeric|unique:users',
            'password' => 'required|string|min:6|max:255',
            'role' => 'nullable|string|in:user,admin'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 255 karakter',
            'username.required' => 'Username harus diisi',
            'username.string' => 'Username harus berupa string',
            'username.unique' => 'Username sudah terdaftar',
            'username.max' => 'Username maksimal 255 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah terdaftar',
            'email.max' => 'Email maksimal 255 karakter',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.numeric' => 'Nomor telepon harus berupa angka',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.string' => 'Password harus berupa string',
            'password.min' => 'Password minimal 6 karakter',
            'password.max' => 'Password maksimal 255 karakter',
            'role.required' => 'Role harus diisi',
            'role.string' => 'Role harus berupa string',
            'role.in' => 'Role harus user atau admin'
        ];
    }
}
