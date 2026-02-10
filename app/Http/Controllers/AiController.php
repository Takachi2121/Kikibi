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
            'nama'               => 'nullable|string',
            'penerima'           => 'nullable|string',
            'usia'               => 'nullable|string',
            'gender'             => 'nullable|string',
            'level_kepentingan'  => 'nullable|string',
            'momen'              => 'nullable|string',
            'prioritas'          => 'nullable|string',
            'budget'             => 'nullable|numeric',
            'minat'              => 'nullable|string',
            'gaya'               => 'nullable|string',
        ]);

        $promptData = [];
        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $promptData[] = "- $key: $value";
            }
        }

        $prompt = "
        Kamu adalah AI asisten rekomendasi hadiah untuk UMKM lokal.

        Tugasmu:
        Berikan SARAN KARAKTERISTIK HADIAH (bukan nama produk).

        Data yang tersedia:
        " . implode("\n", $promptData) . "

        Balas HANYA dalam format JSON berikut (tanpa teks tambahan):
        {
            \"kategori\": [\"\"],
            \"gaya\": [\"\"],
            \"kata_kunci\": [\"\"],
            \"alasan\": \"\"
        }";

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
            'momen'  => $request->input('momen', ''),
            'gender' => $request->input('gender', ''),
            'usia'   => $request->input('usia', ''),
            'max'    => $request->input('budget', ''),
        ])->with('responseAI', $ai);
    }
}

