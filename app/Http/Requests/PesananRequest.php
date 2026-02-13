<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PesananRequest extends FormRequest
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
            'produk_id' => 'required|integer|exists:produks,id',
            'user_id' => 'required|integer|exists:users,id',
            'nama_penerima' => 'required|string|max:255',
            'alamat_penerima' => 'required|string|max:500',
            'jumlah' => 'required|integer|min:1|max:1000',
            'status' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'produk_id.required' => 'Produk wajib dipilih.',
            'user_id.required' => 'Pengirim wajib dipilih.',
            'nama_penerima.required' => 'Nama penerima wajib diisi.',
            'alamat_penerima.required' => 'Alamat penerima wajib diisi.',
            'jumlah.required' => 'Jumlah pesanan wajib diisi.',
            'jumlah.min' => 'Jumlah pesanan minimal 1.',
            'jumlah.max' => 'Jumlah pesanan maksimal 1000.',
            'status.required' => 'Status pesanan wajib diisi.',
        ];
    }
}
