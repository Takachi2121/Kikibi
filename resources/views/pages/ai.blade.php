@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Cari Rekomendasi AI</h1>
        <div class="col-12">
            <label for="namaAI">Nama Penerima</label>
            <input type="text" class="form-control" name="namaPenerima" id="namaAI">
        </div>
        <div class="row">
            <div class="col-4">
                <label for="namaAI">Nama Penerima</label>
                <input type="text" class="form-control" name="namaPenerima" id="namaAI">
            </div>
            <div class="col-4">
                <label for="namaAI">Nama Penerima</label>
                <input type="text" class="form-control" name="namaPenerima" id="namaAI">
            </div>
            <div class="col-4">
                <label for="kelaminAI">Jenis Kelamin Penerima</label>
                <input type="radio" name="lakiPenerima" value="Laki-Laki">Laki-Laki
                <input type="radio" name="perempuanPenerima" value="Perempuan">Perempuan
            </div>
        </div>
    </div>
@endsection
