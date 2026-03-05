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
            'diskon' => 'required|integer|min:0|max:100',
            'harga_akhir' => 'nullable|integer',
            'tanggal_selesai' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'produk_id.required' => 'Produk wajib dipilih.',
            'produk_id.integer' => 'Produk harus berupa angka.',
            'produk_id.exists' => 'Produk tidak ditemukan.',
            'harga_akhir.integer' => 'Harga Akhir harus berupa angka.',
            'diskon.required' => 'Diskon wajib diisi.',
            'diskon.integer' => 'Diskon harus berupa angka.',
            'diskon.min' => 'Diskon minimal 0.',
            'diskon.max' => 'Diskon maksimal 100.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
        ];
    }
}
