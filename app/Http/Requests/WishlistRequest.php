<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WishlistRequest extends FormRequest
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
        if(request()->isMethod('patch')){
            return [
                'total' => 'required|integer|min:1',
            ];
        }

        return [
            'user_id' => 'required|integer|exists:users,id',
            'produk_id' => 'required|integer|exists:produks,id',
            'total' => 'required|integer|min:1|max:10',
        ];
    }

    public function message()
    {
        return [
            'user_id.required' => 'Pengirim wajib dipilih.',
            'produk_id.required' => 'Produk wajib dipilih.',
            'total.required' => 'Jumlah pesanan wajib diisi.',
            'total.min' => 'Jumlah pesanan minimal 1.',
            'total.max' => 'Jumlah pesanan maksimal 10.',
        ];
    }
}
