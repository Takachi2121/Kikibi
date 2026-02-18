<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimoniRequest;
use App\Models\Testimoni;
use App\Http\Requests\StoreTestimoniRequest;
use App\Http\Requests\UpdateTestimoniRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class TestimoniController extends Controller
{
    use AuthorizesRequests;
    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimoniRequest $request)
    {
        $this->authorize('create', Testimoni::class);

        $data = $request->validated();

        if($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $request->input('nama') . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/Testimoni'), $filename);
            $data['foto'] = $filename;
        }

        Testimoni::create($data);

        Cache::forget('testimoni_all');

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil dibuat',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestimoniRequest $request, Testimoni $testimoni_action)
    {
        $this->authorize('update', $testimoni_action);

        $testimoni_action->nama = $request->input('nama', $testimoni_action->nama);
        $testimoni_action->rating = $request->input('rating', $testimoni_action->rating);
        $testimoni_action->komentar = $request->input('komentar', $testimoni_action->komentar);

        $data = $request->validated();

        if($request->hasFile('foto')) {
            if($testimoni_action->foto) {
                $existingFile = public_path('assets/img/Testimoni/' . $testimoni_action->foto);
                if(file_exists($existingFile)) {
                    unlink($existingFile);
                }
            }
            $file = $request->file('foto');
            $filename = $request->input('nama') . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/img/Testimoni'), $filename);
            $data['foto'] = $filename;
        }

        $testimoni_action->update($data);

        Cache::forget('testimoni_all');

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil diubah',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimoni $testimoni_action)
    {
        $testimoni_action->delete();

        Cache::forget('testimoni_all');

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil dihapus',
        ]);
    }
}
