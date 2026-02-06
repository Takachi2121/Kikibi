<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'namaUser' => 'required',
            'emailUser' => 'required|unique:users,email',
            'telpUser' => 'required|numeric',
            'passwordUser' => 'required',
            'confirmUser' => 'required|same:passwordUser'
        ];
    }

    public function messages()
    {
        return [
            'emailUser.unique' => 'Email sudah terdaftar',
            'confirmUser.same' => 'Password tidak sama',
            'namaUser.required' => 'Nama tidak boleh kosong',
            'emailUser.required' => 'Email tidak boleh kosong',
            'telpUser.required' => 'Nomor Telepon tidak boleh kosong',
            'passwordUser.required' => 'Password tidak boleh kosong',
            'confirmUser.required' => 'Konfirmasi Password tidak boleh kosong',
        ];
    }
}
