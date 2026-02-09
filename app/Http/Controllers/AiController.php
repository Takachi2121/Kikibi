<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function cari(Request $request)
    {
        $data = $request->validate([
            'nama'                => 'required',
            'penerima'            => 'required',
            'usia'                => 'required',
            'gender'              => 'required',
            'level_kepentingan'   => 'required',
            'momen'               => 'required',
            'prioritas'           => 'required',
            'budget'              => 'required',
            'minat'               => 'required',
            'gaya'                => 'required',
        ]);

        $prompt = "
        Kamu adalah AI asisten rekomendasi hadiah untuk UMKM lokal.

        Tugasmu:
        Berikan SARAN KARAKTERISTIK HADIAH (bukan nama produk).

        Data:
        - Nama: {$data['nama']}
        - Hubungan dengan penerima: {$data['penerima']}
        - Perkiraan usia: {$data['usia']}
        - Gender: {$data['gender']}
        - Momen pemberian hadiah: {$data['momen']}
        - Tingkat kepentingan momen: {$data['level_kepentingan']}
        - Budget maksimal: {$data['budget']}
        - Prioritas utama: {$data['prioritas']}
        - Minat penerima: {$data['minat']}
        - Gaya hadiah yang diinginkan: {$data['gaya']}

        Balas HANYA dalam format JSON berikut (tanpa teks tambahan):
            {
            \"kategori\": [\"\"],
            \"gaya\": [\"\"],
            \"kata_kunci\": [\"\"],
            \"alasan\": \"\"
            }
        ";

        $response = Http::post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-3-flash-preview:generateContent?key=' . env('GEMINI_API_KEY'),
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]
        );

        if ($response->failed()) {
            abort(500, 'AI gagal merespon');
        }

        $raw = $response['candidates'][0]['content']['parts'][0]['text'];

        // 🔐 AMAN: ambil JSON saja
        preg_match('/\{.*\}/s', $raw, $match);
        $ai = json_decode($match[0] ?? '{}', true);

        // 👉 REDIRECT pakai QUERY
        return redirect()->route('etalase', [
            'ai'     => 1,
            'momen'  => $data['momen'],
            'gender' => $data['gender'],
            'usia'   => $data['usia'],
            'max'    => $data['budget'],
        ])->with('responseAI', $ai);
    }
}

