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

        $apiKeys = explode(',', env('GEMINI_API_KEYS'));
        $response = null;
        $success = false;
        $lastErrorMessage = 'Semua API Key gagal merespon';

        foreach ($apiKeys as $apiKey) {
            $apiKey = trim($apiKey);
            if (empty($apiKey)) continue;

            try {
                $response = Http::timeout(60)->post(
                    'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-lite-latest:generateContent?key=' . $apiKey,
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

                if ($response->successful()) {
                    $success = true;
                    break;
                } else {
                    $errorData = $response->json();
                    $lastErrorMessage = $errorData['error']['message'] ?? 'API Key gagal merespon dengan kode ' . $response->status();
                }
            } catch (\Exception $e) {
                $lastErrorMessage = 'Koneksi API Error: ' . $e->getMessage();
                continue;
            }
        }

        if (!$success) {
            abort(500, 'API Error: ' . $lastErrorMessage);
        }

        $raw = $response['candidates'][0]['content']['parts'][0]['text'];

        // 🔐 AMAN: ambil JSON saja
        preg_match('/\{.*\}/s', $raw, $match);
        $ai = json_decode($match[0] ?? '{}', true);

        session(['responseAI' => $ai]);

        // 👉 REDIRECT pakai QUERY
        return redirect()->route('etalase', [
            'ai'     => 1,
            'momen'  => $request->input('momen', ''),
            'gender' => $request->input('gender', ''),
            'usia'   => $request->input('usia', ''),
            'max'    => $request->input('budget', ''),
        ]);
    }
}

