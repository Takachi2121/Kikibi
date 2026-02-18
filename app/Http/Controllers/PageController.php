<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Testimoni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function home()
    {
        $active = 'home';
        $allProduk = Produk::all();

        if ($allProduk->count() >= 4) {
            $produk = $allProduk->random(4);
        } else {
            $produk = $allProduk;
        }
        $testimoni = Testimoni::orderBy('created_at', 'desc')->take(6)->get();

        return view('pages.home', compact('active', 'produk', 'testimoni'));
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

        // Mapping slider budget ke nominal
        $budgetMapping = [
            0 => 100000,
            1 => 100000,
            2 => 200000,
            3 => 300000,
            4 => 400000,
            5 => 500000,
            6 => 5000000,
        ];

        $maxHarga = $budgetMapping[$request->input('max')] ?? null;

        $data = Produk::when($isAI, function ($q) use ($request, $maxHarga) {

            // Filter momen jika ada
            if ($request->filled('momen')) {
                $q->where('untuk_momen', 'LIKE', '%' . $request->input('momen') . '%');
            }

            // Filter gender jika ada
            if ($request->filled('gender')) {
                $q->where('untuk_gender', $request->input('gender'));
            }else{
                $q->whereIn('untuk_gender', ['Pria', 'Wanita', 'Unisex']);
            }

            // Filter usia jika ada
            if ($request->filled('usia')) {
                switch ($request->input('usia')) {
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

                    case '36 - 45':
                        $q->where('umur_max', '>=', 36);
                        break;

                    case '> 45':
                        $q->where('umur_min', '>=', 45);
                        break;
                }
            }

            // Filter harga jika ada
            if (!empty($maxHarga)) {
                $q->where('harga', '<=', intval($maxHarga));
            }

        })
        ->orderBy('id', 'desc')
        ->get();

        return view('pages.etalase', compact('active', 'data', 'isAI', 'responseAI'));
    }


    public function detail($id)
    {
        $active = 'produk';

        $data = Produk::with('kategori')->findOrFail($id);

        $produkLain = Produk::where('id', '!=', $id)
                        ->where('kategori_id', $data->kategori_id)
                        ->orderBy('id', 'desc')
                        ->take(4)
                        ->get();

        return view('pages.detail', compact('active', 'data', 'produkLain'));
    }

    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    // Admin Pages
    public function kategori(){
        $active = 'kategori';
        $data = Kategori::all();
        return view('admin.pages.kategori', compact('active', 'data'));
    }

    public function produk(){
        $active = 'produk';
        $data = Cache::remember('produk_all', 60, function() {
            return Produk::with('kategori')->get();
        });
        return view('admin.pages.produk.index', compact('active', 'data'));
    }

    public function pesanan(){
        $active = 'pesanan';

        $data = Cache::remember('pesanan_all', 60, function() {
            return Pesanan::with('produk')
                ->orderByRaw("
                    FIELD(status,
                        'Pending',
                        'Dikirim',
                        'Selesai'
                    )
                ")
                ->orderBy('created_at', 'desc')
                ->get();
        });

        $users = Cache::remember('users_all', 60, function() {
            return User::all();
        });

        $produk = Cache::remember('produk_all_keyed', 60, function() {
            return Produk::all();
        });


        return view('admin.pages.pesanan', compact('active', 'data', 'produk', 'users'));
    }

    public function testimoni(){
        $active = 'testimoni';
        $data = Cache::remember('testimoni_all', 60, function() {
            return Testimoni::all();
        });
        return view('admin.pages.testimoni', compact('active', 'data'));
    }

    public function pengaturan(){
        $active = 'pengaturan';
        return view('admin.pages.pengaturan', compact('active'));
    }
}
