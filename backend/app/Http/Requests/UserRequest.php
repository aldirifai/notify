<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $this->user->id,
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'phone' => 'required|string|max:255|unique:users,phone,' . $this->user->id,
            'role' => 'required|in:admin,user',
            'password' => 'nullable|string|min:6',
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
            'username.max' => 'Username maksimal 255 karakter',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah digunakan',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.string' => 'Nomor telepon harus berupa string',
            'phone.max' => 'Nomor telepon maksimal 255 karakter',
            'phone.unique' => 'Nomor telepon sudah digunakan',
            'role.required' => 'Role harus diisi',
            'role.in' => 'Role harus berupa admin atau user',
            'password.string' => 'Password harus berupa string',
            'password.min' => 'Password minimal 6 karakter',
        ];
    }
}
