<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiskonRequest;
use App\Models\Diskon;
use App\Models\Produk;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class DiskonController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active = 'diskon';
        $data = Cache::remember('diskon_all', 60, function() {
            return Diskon::whereDate('tanggal_selesai', '>=', now())
                ->orderBy('tanggal_selesai', 'asc')
                ->get();
        });
        $produk = Produk::all();

        return view('admin.pages.diskon', compact('active', 'data', 'produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiskonRequest $request)
    {
        $this->authorize('create', Diskon::class);
        $data = new Diskon();

        $produk = Produk::findOrFail($request->input('produk_id'));

        $data->produk_id = $request->input('produk_id');
        $data->diskon = $request->input('diskon');
        $data->harga_akhir = $produk->harga - ($produk->harga * $request->input('diskon') / 100);
        $data->tanggal_selesai = date('Y-m-d', strtotime($request->input('tanggal_selesai')));

        $data->save();

        Cache::forget('diskon_all');
        return response()->json([
            'success' => true,
            'message' => 'Diskon telah ditambahkan!'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiskonRequest $request, Diskon $diskon)
    {
        $this->authorize('update', $diskon);

        $data = Diskon::find($diskon->id);

        $produk = Produk::findOrFail($request->input('produk_id'));

        $data->produk_id = $request->input('produk_id');
        $data->diskon = $request->input('diskon');
        $data->harga_akhir = $produk->harga - ($produk->harga * $request->input('diskon') / 100);
        $data->tanggal_selesai = date('Y-m-d', strtotime($request->input('tanggal_selesai')));

        $data->update();
        Cache::forget('diskon_all');

        return response()->json([
            'success' => true,
            'message' => 'Diskon telah diperbarui!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diskon $diskon)
    {
        $this->authorize('delete', $diskon);
        Diskon::destroy($diskon->id);

        Cache::forget('diskon_all');

        return response()->json([
            'success' => true,
            'message' => 'Diskon telah dihapus!'
        ]);
    }
}
