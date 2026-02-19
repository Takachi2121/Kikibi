<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Http\Requests\NotifikasiRequest;
use App\Http\Requests\UpdateNotifikasiRequest;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function notifAll()
    {
        $notif = Notifikasi::with('user:id,nama_lengkap')
            ->where('user_id', Auth::id())
            ->where('jenis_notif', '!=', '0')
            ->limit(3)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($notif);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function notifRead()
    {
        Notifikasi::where('user_id', auth()->id())
            ->where('is_read', '0')
            ->update(['is_read' => '1']);

        return response()->json(['success' => true]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotifikasiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notifikasi $notifikasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notifikasi $notifikasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotifikasiRequest $request, Notifikasi $notifikasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notifikasi $notifikasi)
    {
        //
    }
}
