<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReminderRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->user()->role === 'admin') {
            return [
                'created_by' => ['required', 'exists:users,id'],
                'category_id' => ['nullable', 'exists:categories,id'],
                'title' => ['required'],
                'description' => ['nullable'],
                'repeat_type' => ['nullable', 'in:once,daily,weekly,monthly,yearly'],
                'notification_date_time' => ['nullable', 'date:Y-m-d H:i:s'],
                'deadline_date_time' => ['nullable', 'date:Y-m-d H:i:s'],
                'is_done' => ['nullable', 'in:true,false'],
                'is_important' => ['nullable', 'in:true,false'],
            ];
        }

        return [
            'created_by' => ['nullable', 'exists:users,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required'],
            'description' => ['nullable'],
            'repeat_type' => ['nullable', 'in:once,daily,weekly,monthly,yearly'],
            'notification_date_time' => ['nullable', 'date:Y-m-d H:i:s'],
            'deadline_date_time' => ['nullable', 'date:Y-m-d H:i:s'],
            'is_done' => ['nullable', 'in:true,false'],
            'is_important' => ['nullable', 'in:true,false'],
        ];
    }

    public function messages(): array
    {
        return [
            'created_by.required' => 'Pembuat harus diisi',
            'created_by.exists' => 'Pembuat tidak ditemukan',
            'category_id.exists' => 'Kategori tidak ditemukan',
            'title.required' => 'Judul harus diisi',
            'repeat_type.in' => 'Tipe pengulangan harus once, daily, weekly, monthly, atau yearly',
            'notification_date_time.date' => 'Tanggal dan waktu notifikasi harus berupa tanggal dan waktu (YYYY-MM-DD HH:MM:SS)',
            'deadline_date_time.date' => 'Tanggal dan waktu deadline harus berupa tanggal dan waktu (YYYY-MM-DD HH:MM:SS)',
            'is_done.in' => 'Status selesai harus berupa boolean',
            'is_important.in' => 'Status penting harus berupa boolean',
        ];
    }
}
