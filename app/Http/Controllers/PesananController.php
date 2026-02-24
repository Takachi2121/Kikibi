<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesananRequest;
use App\Models\Notifikasi;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

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
        $data->notelp_penerima = $request->input('notelp_penerima');
        $data->catatan = $request->input('catatan');
        $data->jumlah = $request->input('jumlah');
        $data->total_harga = $request->input('jumlah') * Produk::find($request->input('produk_id'))->harga;
        $data->status = $request->input('status');
        $data->save();

        if($data->status == 'Pending'){
            $notif = new Notifikasi;
            $notif->user_id = $request->input('user_id');
            $notif->jenis_notif = '1';
            $notif->pesan = 'Pesanan '. Produk::find($request->input('produk_id'))->nama_produk .' sedang dikirim';

            $notif->save();

            Mail::send('email.pesanan', [
                'user_name' => $data->user->name, // pengirim
                'user_phone' => $data->user->no_telp,
                'user_email' => $data->user->email,
                'receiver_name' => $data->nama_penerima, // penerima
                'receiver_address' => $data->alamat_penerima,
                'receiver_phone' => $data->notelp_penerima,
                'catatan' => $data->catatan,
                'items' => [$data], // list produk
                'total_harga' => $data->produk->harga * $data->jumlah,
                'status' => $data->status
            ], function($msg) use ($data) {
                $msg->to($data->user->email)
                    ->subject('Pesanan Anda Sedang Diproses - Kikibi');
            });
        }

        if($data->status == 'Dikirim'){
            $notif = new Notifikasi;
            $notif->user_id = $request->input('user_id');
            $notif->jenis_notif = '2';
            $notif->pesan = 'Pesanan '. Produk::find($request->input('produk_id'))->nama_produk .' sedang dikirim';

            $notif->save();

            Mail::send('email.pesanan', [
                'user_name' => $data->user->name, // pengirim
                'user_phone' => $data->user->no_telp,
                'user_email' => $data->user->email,
                'receiver_name' => $data->nama_penerima, // penerima
                'receiver_address' => $data->alamat_penerima,
                'receiver_phone' => $data->notelp_penerima,
                'catatan' => $data->catatan,
                'items' => [$data], // list produk
                'total_harga' => $data->produk->harga * $data->jumlah,
                'status' => $data->status
            ], function($msg) use ($data) {
                $msg->to($data->user->email)
                    ->subject('Pesanan Anda Sedang Dikirim - Kikibi');
            });
        }

        if($data->status == 'Selesai'){
            $notif = new Notifikasi;
            $notif->user_id = $request->input('user_id');
            $notif->jenis_notif = '3';
            $notif->pesan = 'Pesanan '. Produk::find($request->input('produk_id'))->nama_produk .' sudah diterima';

            $notif->save();

            Mail::send('email.pesanan', [
                'user_name' => $data->user->name, // pengirim
                'user_phone' => $data->user->no_telp,
                'user_email' => $data->user->email,
                'receiver_name' => $data->nama_penerima, // penerima
                'receiver_address' => $data->alamat_penerima,
                'receiver_phone' => $data->notelp_penerima,
                'catatan' => $data->catatan,
                'items' => [$data], // list produk
                'total_harga' => $data->produk->harga * $data->jumlah,
                'status' => $data->status
            ], function($msg) use ($data) {
                $msg->to($data->user->email)
                    ->subject('Pesanan Anda Sudah Diterima - Kikibi');
            });
        }

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
    public function update(PesananRequest $request, Pesanan $pesanan_action)
    {
        $this->authorize('update', $pesanan_action);

        $pesanan_action->update($request->all());

        if($pesanan_action->status == 'Pending'){
            $notif = new Notifikasi;
            $notif->user_id = $request->input('user_id');
            $notif->jenis_notif = '1';
            $notif->pesan = 'Pesanan '. Produk::find($request->input('produk_id'))->nama_produk .' sedang dikirim';

            $notif->save();

            Mail::send('email.pesanan', [
                'user_name' => $pesanan_action->user->name, // pengirim
                'user_phone' => $pesanan_action->user->no_telp,
                'user_email' => $pesanan_action->user->email,
                'receiver_name' => $pesanan_action->nama_penerima, // penerima
                'receiver_address' => $pesanan_action->alamat_penerima,
                'receiver_phone' => $pesanan_action->notelp_penerima,
                'catatan' => $pesanan_action->catatan,
                'items' => [$pesanan_action], // list produk
                'total_harga' => $pesanan_action->produk->harga * $pesanan_action->jumlah,
                'status' => $pesanan_action->status
            ], function($msg) use ($pesanan_action) {
                $msg->to($pesanan_action->user->email)
                    ->subject('Pesanan Anda Sedang Diproses - Kikibi');
            });
        }

        if($pesanan_action->status == 'Dikirim'){
            $notif = new Notifikasi;
            $notif->user_id = $request->input('user_id');
            $notif->jenis_notif = '2';
            $notif->pesan = 'Pesanan '. Produk::find($request->input('produk_id'))->nama_produk .' sedang dikirim';

            $notif->save();

            Mail::send('email.pesanan', [
                'user_name' => $pesanan_action->user->name, // pengirim
                'user_phone' => $pesanan_action->user->no_telp,
                'user_email' => $pesanan_action->user->email,
                'receiver_name' => $pesanan_action->nama_penerima, // penerima
                'receiver_address' => $pesanan_action->alamat_penerima,
                'receiver_phone' => $pesanan_action->notelp_penerima,
                'catatan' => $pesanan_action->catatan,
                'items' => [$pesanan_action], // list produk
                'total_harga' => $pesanan_action->produk->harga * $pesanan_action->jumlah,
                'status' => $pesanan_action->status
            ], function($msg) use ($pesanan_action) {
                $msg->to($pesanan_action->user->email)
                    ->subject('Pesanan Anda Sedang Dikirim - Kikibi');
            });
        }

        if($pesanan_action->status == 'Selesai'){
            $notif = new Notifikasi;
            $notif->user_id = $request->input('user_id');
            $notif->jenis_notif = '3';
            $notif->pesan = 'Pesanan '. Produk::find($request->input('produk_id'))->nama_produk .' sudah diterima';

            $notif->save();


            Mail::send('email.pesanan', [
                'user_name' => $pesanan_action->user->name, // pengirim
                'user_phone' => $pesanan_action->user->no_telp,
                'user_email' => $pesanan_action->user->email,
                'receiver_name' => $pesanan_action->nama_penerima, // penerima
                'receiver_address' => $pesanan_action->alamat_penerima,
                'receiver_phone' => $pesanan_action->notelp_penerima,
                'catatan' => $pesanan_action->catatan,
                'items' => [$pesanan_action], // list produk
                'total_harga' => $pesanan_action->produk->harga * $pesanan_action->jumlah,
                'status' => $pesanan_action->status
            ], function($msg) use ($pesanan_action) {
                $msg->to($pesanan_action->user->email)
                    ->subject('Pesanan Anda Sudah Diterima - Kikibi');
            });
        }

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
