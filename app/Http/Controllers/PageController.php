<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Testimoni;
use App\Models\User;
use App\Models\Wishlist;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mail;

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
        $isAI = $request->input('ai') == 1;
        $responseAI = session('responseAI');

        // Mapping slider budget ke nominal
        // $budgetMapping = [
        //     0 => 100000,
        //     1 => 100000,
        //     2 => 200000,
        //     3 => 300000,
        //     4 => 400000,
        //     5 => 500000,
        //     6 => 5000000,
        // ];

        // $maxHarga = $budgetMapping[$request->input('max')] ?? null;

        $data = Produk::when($isAI, function ($q) use ($request) {

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
            // if (!empty($maxHarga)) {
            //     $q->where('harga', '<=', intval($maxHarga));
            // }

            // if ($request->input('max') == 0){
            //     $q->where('harga', '<=', 100000);
            // }

        })
        ->orderBy('id', 'desc')
        ->get();

        return view('pages.etalase', compact('active', 'data', 'isAI', 'responseAI'));
    }


    public function detail($id)
    {
        $active = 'produk';

        $data = Produk::with('kategori')->findOrFail($id);

        $limit = 2;

        $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('produk_id', $id)->first();

        // Produk lain berdasarkan kategori
        $produkLain = Produk::where('id' , '!=', $id)
            ->where('kategori_id', $data->kategori_id)
            ->orderBy('id', 'desc')
            ->take($limit)
            ->get();

        // Kalau kurang, ambil tambahan berdasarkan momen
        if ($produkLain->count() < $limit) {
            $kekurangan = $limit - $produkLain->count();
            $momenArray = explode(',', $data->untuk_momen);

            $produkMomen = Produk::where('id', '!=', $id)
                ->whereNotIn('id', $produkLain->pluck('id'))
                ->where(function($q) use ($momenArray) {
                    foreach ($momenArray as $momen) {
                        $q->orWhere('untuk_momen', 'LIKE', "%{$momen}%");
                    }
                })
                ->orderBy('id', 'desc')
                ->take($kekurangan)
                ->get();

            $produkLain = $produkLain->concat($produkMomen);
        }

        return view('pages.detail', compact('active', 'wishlist', 'data', 'produkLain'));
    }

    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function wishlist(){
        $active = 'wishlist';
        $data = Wishlist::where('user_id', auth()->user()->id)->get();
        return view('pages.wishlist', compact('active', 'data'));
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

    public function checkout(Request $request, $id){
        $request->validate([
            'produk_id' => 'required|integer|exists:produks,id',
            'user_id' => 'required|integer|exists:users,id',
            'nama_penerima' => 'required|string|max:255',
            'alamat_penerima' => 'required|string|max:500',
            'notelp_penerima' => 'required|numeric|min:10',
            'catatan' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1|max:1000',
            'status' => 'required|string|max:50',
        ],[
            'produk_id.required' => 'Produk wajib dipilih.',
            'user_id.required' => 'Pengirim wajib dipilih.',
            'nama_penerima.required' => 'Nama penerima wajib diisi.',
            'alamat_penerima.required' => 'Alamat penerima wajib diisi.',
            'jumlah.required' => 'Jumlah pesanan wajib diisi.',
            'jumlah.min' => 'Jumlah pesanan minimal 1.',
            'jumlah.max' => 'Jumlah pesanan maksimal 1000.',
            'status.required' => 'Status pesanan wajib diisi.',
            'notelp_penerima.required' => 'Nomor telepon penerima wajib diisi.',
            'notelp_penerima.min' => 'Nomor telepon penerima minimal 10 angka.',
            'catatan.max' => 'Catatan maksimal 255 karakter.',
            'alamat_penerima.max' => 'Alamat penerima maksimal 500 karakter.',
        ]);

        $user = Auth::user();
        $data = Produk::findorFail($id);

        $pesanan = new Pesanan();

        $pesanan->user_id = $user->id;
        $pesanan->produk_id = $data->id;
        $pesanan->nama_penerima = $request->input('nama_penerima');
        $pesanan->alamat_penerima = $request->input('alamat_penerima');
        $pesanan->notelp_penerima = $request->input('notelp_penerima');
        $pesanan->catatan = $request->input('catatan_penerima');
        $pesanan->jumlah = $request->input('jumlah');
        $pesanan->total_harga = $data->harga * (int) $request->input('jumlah');
        $pesanan->status = 'Pending';
        $data->jumlah = $request->input('jumlah');

        Mail::send('email.checkout', [
            'user_name' => $user->nama_lengkap, // pengirim
            'user_phone' => $user->no_telp,
            'user_email' => $user->email,
            'receiver_name' => $request->input('nama_penerima'), // penerima
            'receiver_address' => $request->input('alamat_penerima'),
            'receiver_phone' => $request->input('notelp_penerima'),
            'catatan' => $request->input('catatan_penerima'),
            'items' => [$data], // list produk
            'total_harga' => $data->harga * $request->input('jumlah'),
            'status' => 'Perlu Diproses'
        ], function($msg) use ($user) {
            $msg->to($user->email)
                ->subject('Terima Kasih sudah melakukan Checkout - Kikibi');
        });

        Mail::send('email.checkout', [
            'user_name' => $user->nama_lengkap, // pengirim
            'user_phone' => $user->no_telp,
            'user_email' => $user->email,
            'receiver_name' => $request->input('nama_penerima'), // penerima
            'receiver_address' => $request->input('alamat_penerima'),
            'receiver_phone' => $request->input('notelp_penerima'),
            'catatan' => $request->input('catatan_penerima'),
            'items' => [$data], // list produk
            'total_harga' => $data->harga * $request->input('jumlah'),
            'status' => 'Perlu Diproses'
        ], function($msg) use ($user) {
            $msg->to('official.kikibi@gmail.com')
                ->subject('Pesanan Diterima - Kikibi');
        });

        $pesanan->save();

        if($request->input('wishlist')){
            Wishlist::where('user_id', auth()->user()->id)->where('produk_id', $id)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil di Checkout'
        ]);
    }
}
