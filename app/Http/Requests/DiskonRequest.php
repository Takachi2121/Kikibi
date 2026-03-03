<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiskonRequest extends FormRequest
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
            'diskon' => 'required|integer',
            'harga_akhir' => 'required|integer',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'produk_id.required' => 'Produk wajib dipilih.',
            'harga_akhir.required' => 'Harga Akhir wajib diisi.',
            'harga_akhir.integer' => 'Harga Akhir harus berupa angka.',
            'diskon.required' => 'Diskon wajib diisi.',
            'diskon.integer' => 'Diskon harus berupa angka.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
        ];
    }
}
