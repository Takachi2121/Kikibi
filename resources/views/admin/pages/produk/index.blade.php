@extends('admin.main')

@section('title', 'Data Produk')
@section('subtitle', 'Kelola data Produk di sini.')

@section('mainContent')
<link rel="stylesheet" href="{{ asset('assets/css/main/table.css')}}">

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p class="fw-semibold fs-4">List Data Produk</p>
            </div>
            <div class="col-md-6 text-end align-self-center">
                <a href="{{ route('produk-action.create') }}" class="btn btn-primary mb-3">
                    <i class="fa-solid fa-plus"></i> Tambah Produk
                </a>
            </div>
        </div>
        <table id="ProduksTable" class="table table-bordered table-striped" style="width:100%; table-layout: fixed;">
            <thead class="table-dark">
                <tr>
                    <th style="width: 3%">No</th>
                    <th style="width: 10%">Nama Produk</th>
                    <th>Harga</th>
                    <th style="width: 15%">Untuk Momen</th>
                    <th>Kategori</th>
                    <th>Foto 1</th>
                    <th>Foto 2</th>
                    <th>Foto 3</th>
                    <th>Foto 4</th>
                    <th>Foto 5</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $produk)
                    <tr>
                        <td style="width: 2%">{{ $loop->iteration }}</td>
                        <td style="width: 10%">{{ $produk->nama_produk }}</td>
                        <td>Rp. {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td style="width: 15%">
                            @foreach(explode(',', $produk->untuk_momen) as $momen)
                                <span class="badge bg-danger text-white me-1">
                                    {{ trim($momen) }}
                                </span>
                            @endforeach
                        </td>
                        <td>{{ $produk->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</td>
                        @for ($i = 1; $i <= 5; $i++)
                            @if($produk->{"foto_$i"})
                            <td>
                                <img src="{{ asset('assets/img/Produk/' . $produk->{"foto_$i"}) }}" alt="Foto {{ $i }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            </td>
                            @else
                            <td class="text-center">
                                <span class="text-muted">No Image</span>
                            </td>
                            @endif
                        @endfor
                        <td class="text-center gap-2  justify-content-center h-100">
                            <a href="{{ route('produk-action.edit', $produk->id) }}" class="text-decoration-none text-white btn btn-sm btn-warning">
                                <i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Edit</button>
                            </a>
                            <form class="d-inline form-delete-Produk" data-url="{{ route('produk-action.destroy', $produk->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash"></i>&nbsp;Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js-admin')
<script src="{{ asset('assets/js/main/produk.js') }}"></script>
@endsection
