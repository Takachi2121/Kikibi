<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home(){
        $active = 'home';
        $produk = Produk::all()->random(4);
        return view('pages.home', compact('active', 'produk'));
    }

    public function aiRecommendation(){
        $active = 'ai';

        $momen = Produk::pluck('untuk_momen') // ambil semua
            ->map(function($item) {
                return explode(',', $item); // pecah per koma
            })
            ->flatten() // jadi satu dimensi
            ->map(function($item){
                return trim($item); // buang spasi
            })
            ->unique() // buang duplikat
            ->values() // reset index
            ->toArray();

        return view('pages.ai', compact('active', 'momen'));
    }

    public function etalase(Request $request)
    {
        $active = 'produk';
        $isAI = $request->has('ai');
        $responseAI = session('responseAI', []);

        $budgetMapping = [
            0 => 100000,
            1 => 100000,
            2 => 200000,
            3 => 300000,
            4 => 400000,
            5 => 500000,
            6 => 5000000,
        ];

        $maxHarga = $budgetMapping[$request->max] ?? null;

        $data = Produk::when($isAI, function ($q) use ($request, $maxHarga) {

            // Filter momen
            if (!empty($request->momen)) {
                $q->where('untuk_momen', 'LIKE', '%' . $request->momen . '%');
            }

            // Filter gender
            if (!empty($request->gender)) {
                $q->where('untuk_gender', $request->gender);
            }

            // Filter usia
            if (!empty($request->usia)) {
                switch ($request->usia) {
                    case '< 18':
                        $q->where('umur_min', '<=', 17)
                        ->where('umur_max', '>=', 0);
                        break;

                    case '18 - 25':
                        $q->where('umur_min', '<=', 25)
                        ->where('umur_max', '>=', 18);
                        break;

                    case '26 - 35':
                        $q->where('umur_min', '<=', 35)
                        ->where('umur_max', '>=', 26);
                        break;

                    case '36+':
                        $q->where('umur_max', '>=', 36);
                        break;
                }
            }

            // Filter harga
            if (!empty($maxHarga)) {
                $q->where('harga', '<=', intval($maxHarga));
            }

            if (!empty($maxHarga == 1000000)){
                $q->where('harga', '<=', 1000000);
            }

            // dd($maxHarga);

        })
        ->orderBy('id', 'desc')
        ->get();

        return view('pages.etalase', compact('active', 'data', 'isAI', 'responseAI'));
    }


    public function detail($id){
        $active = 'produk';
        $data = Produk::findorFail($id);
        return view('pages.detail', compact('active', 'data'));
    }

    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }
}
