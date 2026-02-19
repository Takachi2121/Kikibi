<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesananRequest;
use App\Models\Notifikasi;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PesananController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a newly created resource in storage.
     */
    public function store(PesananRequest $request)
    {
        $this->authorize('create', Pesanan::class);

        $data = new Pesanan;
        $data->user_id = $request->input('user_id');
        $data->produk_id = $request->input('produk_id');
        $data->nama_penerima = $request->input('nama_penerima');
        $data->alamat_penerima = $request->input('alamat_penerima');
        $data->jumlah = $request->input('jumlah');
        $data->total_harga = $request->input('jumlah') * Produk::find($request->input('produk_id'))->harga;
        $data->status = $request->input('status');
        $data->save();

        $notif = new Notifikasi;
        $notif->user_id = $request->input('user_id');
        $notif->jenis_notif = '1';
        $notif->pesan = 'Pesanan '. Produk::find($request->input('produk_id'))->nama_produk .' baru saja diproses';
        $notif->save();

        Cache::forget('pesanan_all');
        Cache::forget('produk_all_keyed');
        Cache::forget('users_all');

        return response()->json([
            'message' => 'Pesanan berhasil ditambahkan'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan_action)
    {
        $this->authorize('update', $pesanan_action);

        $pesanan_action->update($request->all());

        if($pesanan_action->status == 'Dikirim'){
            $notif = new Notifikasi;
            $notif->user_id = $request->input('user_id');
            $notif->jenis_notif = '2';
            $notif->pesan = 'Pesanan '. Produk::find($request->input('produk_id'))->nama_produk .' sedang dikirim';
        }

        if($pesanan_action->status == 'Selesai'){
            $notif = new Notifikasi;
            $notif->user_id = $request->input('user_id');
            $notif->jenis_notif = '3';
            $notif->pesan = 'Pesanan '. Produk::find($request->input('produk_id'))->nama_produk .' sudah diterima';
        }

        $notif->save();

        Cache::forget('pesanan_all');
        Cache::forget('produk_all_keyed');
        Cache::forget('users_all');

        return response()->json([
            'message' => 'Pesanan berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan_action)
    {
        $pesanan_action->delete();
        Cache::forget('pesanan_all');
        Cache::forget('produk_all_keyed');
        Cache::forget('users_all');

        return response()->json([
            'message' => 'Pesanan berhasil dihapus'
        ]);
    }
}
