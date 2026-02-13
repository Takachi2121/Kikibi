<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $active = 'pesanan';
        $users = User::all();
        $produks = Produk::all();
        return view('admin.pages.pesanan.tambah', compact('active', 'users', 'produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        $active = 'pesanan';
        return view('admin.pages.pesanan.edit', compact('active', 'pesanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        return redirect()->route('admin-pesanan')->with('success', 'Pesanan berhasil dihapus.');
    }
}
