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
            'nama_produk' => 'required|string|max:255',
            'nama_pengirim' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'status' => 'required|string|max:50',
            'tanggal_pesanan' => 'required|date',
            'tanggal_dikirim' => 'nullable|date|after_or_equal:tanggal_pesanan',
        ];
    }
}
