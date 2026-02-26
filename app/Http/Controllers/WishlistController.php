<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistRequest;
use App\Models\Wishlist;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    use AuthorizesRequests;
    public function store(WishlistRequest $request)
    {
        $this->authorize('create', Wishlist::class);

        $data = new Wishlist();
        $data->user_id = $request->input('user_id');
        $data->produk_id = $request->input('produk_id');
        $data->total = $request->input('total');
        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Wishlist berhasil ditambahkan.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WishlistRequest $request, Wishlist $wishlist_action)
    {
        $this->authorize('update', $wishlist_action);

        $data = Wishlist::find($wishlist_action->id);
        $data->total = $request->input('total');
        $data->update();
        return response()->json([
            'status' => true,
            'message' => 'Wishlist berhasil diubah.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist_action)
    {
        $this->authorize('delete', $wishlist_action);

        $wishlist_action->delete();
        return response()->json([
            'status' => true,
            'message' => 'Wishlist berhasil dihapus.'
        ]);
    }
}
