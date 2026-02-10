<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    use AuthorizesRequests;
    public function store(KategoriRequest $request)
    {
        $this->authorize('create', Kategori::class);

        $data = new Kategori();
        $data->nama_kategori = $request->input('nama_kategori');
        $data->makna_hadiah = $request->input('makna_hadiah');
        $data->save();

        return response()->json(['success' => 'Kategori berhasil ditambahkan.']);
    }

    public function update(KategoriRequest $request, $id)
    {
        $data = Kategori::findorFail($id);

        $this->authorize('update', $data);
        $data->nama_kategori = $request->input('nama_kategori');
        $data->makna_hadiah = $request->input('makna_hadiah');
        $data->update();

        return response()->json(['success' => 'Kategori berhasil diperbarui.']);
    }
    public function destroy($id)
    {
        $data = Kategori::findorFail($id);

        $this->authorize('delete', $data);
        $data->delete();
        return response()->json(['success' => 'Kategori berhasil dihapus.']);
    }
}
