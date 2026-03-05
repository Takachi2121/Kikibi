<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiskonRequest;
use App\Models\Diskon;
use App\Models\Produk;
use Illuminate\Support\Facades\Cache;

class DiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active = 'diskon';
        $data = Cache::remember('diskon_all', 60, function() {
            return Diskon::all();
        });
        $produk = Produk::all();

        return view('admin.pages.diskon', compact('active', 'data', 'produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiskonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Diskon $diskon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diskon $diskon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiskonRequest $request, Diskon $diskon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diskon $diskon)
    {
        //
    }
}
