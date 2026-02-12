<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProdukController extends Controller
{
    use AuthorizesRequests;
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $active = 'produk';
        $kategoris = Kategori::all();
        return view('admin.pages.produk.tambah', compact('active', 'kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdukRequest $request)
    {
        $this->authorize('create', Produk::class);

        $data = new Produk();
        $data->nama_produk = $request->input('nama_produk');
        $data->deskripsi = $request->input('deskripsi_produk');
        $data->harga = $request->input('harga_produk');
        $data->kategori_id = $request->input('kategori_id');
        $data->untuk_momen = $request->input('untuk_momen');
        $data->untuk_gender = $request->input('gender');
        $data->umur_min = $request->input('umur_min');
        $data->umur_max = $request->input('umur_max');
        $data->estimasi = $request->input('estimasi');

        $folder = public_path('assets/img/Produk/');
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true); // true = recursive, bikin folder jika belum ada
        }

        // Handle foto upload
        if ($request->hasFile('foto_1')) {
            $file1 = $request->file('foto_1');
            $filename1 = $request->input('nama_produk') . '_' . time() . '_1.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('assets/img/Produk/'), $filename1);
            $data->foto_1 = $filename1;
        }
        if ($request->hasFile('foto_2')) {
            $file2 = $request->file('foto_2');
            $filename2 = $request->input('nama_produk') . '_' . time() . '_2.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('assets/img/Produk/'), $filename2);
            $data->foto_2 = $filename2;
        }
        if ($request->hasFile('foto_3')) {
            $file3 = $request->file('foto_3');
            $filename3 = $request->input('nama_produk') . '_' . time() . '_3.' . $file3->getClientOriginalExtension();
            $file3->move(public_path('assets/img/Produk/'), $filename3);
            $data->foto_3 = $filename3;
        }
        if ($request->hasFile('foto_4')) {
            $file4 = $request->file('foto_4');
            $filename4 = $request->input('nama_produk') . '_' . time() . '_4.' . $file4->getClientOriginalExtension();
            $file4->move(public_path('assets/img/Produk/'), $filename4);
            $data->foto_4 = $filename4;
        }
        if ($request->hasFile('foto_5')) {
            $file5 = $request->file('foto_5');
            $filename5 = $request->input('nama_produk') . '_' . time() . '_5.' . $file5->getClientOriginalExtension();
            $file5->move(public_path('assets/img/Produk/'), $filename5);
            $data->foto_5 = $filename5;
        }

        $data->save();
        Cache::forget('produk_all');

        return response()->json([
            'success' => 'Produk berhasil ditambahkan.',
            'redirect' => route('admin-produk')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $active = 'produk';
        $kategoris = Kategori::all();
        $produk = Produk::findOrFail($id);
        return view('admin.pages.produk.edit', compact('active', 'produk', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdukRequest $request, $id)
    {
        $data = Produk::findOrFail($id);
        $this->authorize('update', $data);

        $data->nama_produk = $request->input('nama_produk');
        $data->deskripsi = $request->input('deskripsi_produk');
        $data->harga = $request->input('harga_produk');
        $data->kategori_id = $request->input('kategori_id');
        $data->untuk_momen = $request->input('untuk_momen');
        $data->untuk_gender = $request->input('gender');
        $data->umur_min = $request->input('umur_min');
        $data->umur_max = $request->input('umur_max');
        $data->estimasi = $request->input('estimasi');

        // Handle foto upload
        if ($request->hasFile('foto_1')) {
            if($data->foto_1){
                $oldFilePath = public_path('assets/img/Produk/' . $data->foto_1);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $file1 = $request->file('foto_1');
            $filename1 = $request->input('nama_produk') . '_' . time() . '_1.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('assets/img/Produk/'), $filename1);
            $data->foto_1 = $filename1;
        }
        if ($request->hasFile('foto_2')) {
            if($data->foto_2){
                $oldFilePath = public_path('assets/img/Produk/' . $data->foto_2);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $file2 = $request->file('foto_2');
            $filename2 = $request->input('nama_produk') . '_' . time() . '_2.' . $file2->getClientOriginalExtension();
            $file2->move(public_path('assets/img/Produk/'), $filename2);
            $data->foto_2 = $filename2;
        }
        if ($request->hasFile('foto_3')) {
            if($data->foto_3){
                $oldFilePath = public_path('assets/img/Produk/' . $data->foto_3);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $file3 = $request->file('foto_3');
            $filename3 = $request->input('nama_produk') . '_' . time() . '_3.' . $file3->getClientOriginalExtension();
            $file3->move(public_path('assets/img/Produk/'), $filename3);
            $data->foto_3 = $filename3;
        }
        if ($request->hasFile('foto_4')) {
            if($data->foto_4){
                $oldFilePath = public_path('assets/img/Produk/' . $data->foto_4);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $file4 = $request->file('foto_4');
            $filename4 = $request->input('nama_produk') . '_' . time() . '_4.' . $file4->getClientOriginalExtension();
            $file4->move(public_path('assets/img/Produk/'), $filename4);
            $data->foto_4 = $filename4;
        }
        if ($request->hasFile('foto_5')) {
            if($data->foto_5){
                $oldFilePath = public_path('assets/img/Produk/' . $data->foto_5);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $file5 = $request->file('foto_5');
            $filename5 = $request->input('nama_produk') . '_' . time() . '_5.' . $file5->getClientOriginalExtension();
            $file5->move(public_path('assets/img/Produk/'), $filename5);
            $data->foto_5 = $filename5;
        }
        $data->update();
        Cache::forget('produk_all');

        return response()->json([
            'success' => 'Produk berhasil diperbarui.',
            'redirect' => route('admin-produk')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk_action)
    {
        $produk_action->delete();
        if($produk_action->foto_1){
            $oldFilePath = public_path('assets/img/Produk/' . $produk_action->foto_1);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        if($produk_action->foto_2){
            $oldFilePath = public_path('assets/img/Produk/' . $produk_action->foto_2);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        if($produk_action->foto_3){
            $oldFilePath = public_path('assets/img/Produk/' . $produk_action->foto_3);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        if($produk_action->foto_4){
            $oldFilePath = public_path('assets/img/Produk/' . $produk_action->foto_4);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        if($produk_action->foto_5){
            $oldFilePath = public_path('assets/img/Produk/' . $produk_action->foto_5);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        Cache::forget('produk_all');
        return response()->json(['success' => 'Produk berhasil dihapus.']);
    }
}
