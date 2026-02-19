<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotifikasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'pesan' => 'required|string',
            'is_read' => 'required|boolean|in:0,1',
            'jenis_notif' => 'required|integer|in:0,1,2,3',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'ID User diperlukan.',
            'user_id.exists' => 'ID User tidak ditemukan.',
            'user_id.integer' => 'ID User harus berupa angka.',
            'pesan.string' => 'Pesan Notifikasi harus berupa teks.',
            'pesan.required' => 'Pesan Notifikasi diperlukan.',
            'is_read.required' => 'Status dibaca tidak boleh kosong.',
            'is_read.in' => 'Status dibaca diluar pilihan.',
            'jenis_notif.required' => 'Jenis Notifikasi diperlukan.',
            'jenis_notif.in' => 'Jenis Notifikasi diluar pilihan.',
            'jenis_notif.integer' => 'Jenis Notifikasi harus berupa angka.',
        ];
    }
}
