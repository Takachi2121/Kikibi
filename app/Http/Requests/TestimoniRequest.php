<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimoniRequest extends FormRequest
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
        $rules = [
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
        ];

        // rules foto_1 berbeda untuk create vs update
        if ($this->isMethod('POST')) {
            $rules['nama'] = 'required|string|max:255|unique:testimonis,nama';
        } else { // PUT atau PATCH
            $rules['nama'] = 'nullable|string|max:255';
        }

        return $rules;

    }

    public function messages(): array
    {
        $message = [
            'nama.string' => 'Nama testimoni harus berupa teks.',
            'nama.max' => 'Nama testimoni tidak boleh lebih dari 255 karakter.',
            'nama.unique' => 'Nama testimoni sudah ada. Silakan gunakan nama lain.',
            'rating.required' => 'Rating wajib diisi.',
            'rating.integer' => 'Rating harus berupa angka bulat.',
            'rating.min' => 'Rating minimal adalah 1.',
            'rating.max' => 'Rating maksimal adalah 5.',
            'komentar.required' => 'Komentar wajib diisi.',
            'komentar.string' => 'Komentar harus berupa teks.',
            'foto.image' => 'Foto harus berupa file gambar.',
            'foto.mimes' => 'Foto harus berformat jpeg, png atau jpg.',
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 4MB.',
        ];

        if($this->isMethod('POST')) {
            $message['nama.required'] = 'Nama testimoni wajib diisi.';
        }

        return $message;
    }
}
