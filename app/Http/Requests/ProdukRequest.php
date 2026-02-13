<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // rules dasar
        $rules = [
            'nama_produk' => 'required|string|max:255',
            'deskripsi_produk' => 'required|string',
            'harga_produk' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'foto_3' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'foto_4' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'foto_5' => 'nullable|image|mimes:jpeg,png,jpg|max:8192',
            'untuk_momen' => 'required|string|max:255',
            'gender' => 'required|in:Pria,Wanita,Unisex',
            'umur_min' => 'required|integer|min:0|max:99|numeric|gte:0',
            'umur_max' => 'required|integer|min:0|max:99|gte:umur_min',
            'estimasi' => 'required|string|in:1 - 2 Hari,3 - 4 Hari,5 - 7 Hari,8 - 10 Hari',
        ];

        // rules foto_1 berbeda untuk create vs update
        if ($this->isMethod('POST')) {
            $rules['foto_1'] = 'required|image|mimes:jpeg,png,jpg|max:8192';
        } else { // PUT atau PATCH
            $rules['foto_1'] = 'nullable|image|mimes:jpeg,png,jpg|max:8192';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'kategori_id.required' => 'Kategori produk wajib dipilih.',
            'kategori_id.exists' => 'Kategori produk yang dipilih tidak valid.',

            'gender.required' => 'Gender wajib dipilih.',
            'gender.in' => 'Gender yang dipilih tidak valid.',

            'umur_min.required' => 'Umur minimal wajib diisi.',
            'umur_min.integer' => 'Umur minimal harus berupa angka bulat.',
            'umur_min.min' => 'Umur minimal harus >= 0.',
            'umur_min.max' => 'Umur minimal maksimal 99.',
            'umur_min.numeric' => 'Umur minimal harus berupa angka.',
            'umur_min.gte' => 'Umur minimal harus lebih besar atau sama dengan umur maksimal.',

            'umur_max.required' => 'Umur maksimal wajib diisi.',
            'umur_max.integer' => 'Umur maksimal harus berupa angka bulat.',
            'umur_max.min' => 'Umur maksimal harus >= 0.',
            'umur_max.max' => 'Umur maksimal maksimal 99.',
            'umur_max.gte' => 'Umur maksimal harus lebih besar atau sama dengan umur minimal.',

            'harga_produk.required' => 'Harga produk wajib diisi.',
            'harga_produk.numeric' => 'Harga produk harus berupa angka.',
            'harga_produk.min' => 'Harga produk minimal 0.',

            'foto_1.image' => 'Foto produk 1 harus berupa gambar.',
            'foto_1.mimes' => 'Foto produk 1 harus berekstensi jpeg, jpg, atau png.',
            'foto_1.max' => 'Foto produk 1 maksimal 8MB.',
            'foto_2.image' => 'Foto produk 2 harus berupa gambar.',
            'foto_2.mimes' => 'Foto produk 2 harus berekstensi jpeg, jpg, atau png.',
            'foto_2.max' => 'Foto produk 2 maksimal 8MB.',
            'foto_3.image' => 'Foto produk 3 harus berupa gambar.',
            'foto_3.mimes' => 'Foto produk 3 harus berekstensi jpeg, jpg, atau png.',
            'foto_3.max' => 'Foto produk 3 maksimal 8MB.',
            'foto_4.image' => 'Foto produk 4 harus berupa gambar.',
            'foto_4.mimes' => 'Foto produk 4 harus berekstensi jpeg, jpg, atau png.',
            'foto_4.max' => 'Foto produk 4 maksimal 8MB.',
            'foto_5.image' => 'Foto produk 5 harus berupa gambar.',
            'foto_5.mimes' => 'Foto produk 5 harus berekstensi jpeg, jpg, atau png.',
            'foto_5.max' => 'Foto produk 5 maksimal 8MB.',

            'estimasi.required' => 'Estimasi wajib dipilih.',
            'estimasi.in' => 'Estimasi yang dipilih tidak valid.',

            'untuk_momen.string' => 'Untuk momen harus berupa teks.',
            'untuk_momen.required' => 'Untuk momen wajib diisi.',
            'untuk_momen.max' => 'Untuk momen maksimal 255 karakter.',

            'deskripsi_produk.required' => 'Deskripsi produk wajib diisi.',
            'deskripsi_produk.string' => 'Deskripsi produk harus berupa teks.',

            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.string' => 'Nama produk harus berupa teks.',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter.',
        ];

        // pesan khusus foto_1 saat create
        if ($this->isMethod('POST')) {
            $messages['foto_1.required'] = 'Foto produk 1 wajib diupload.';
        }

        return $messages;
    }
}
