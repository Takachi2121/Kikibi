@extends('admin.main')

@section('title', 'Data Pesanan')
@section('subtitle', 'Kelola data Pesanan di sini.')

@section('mainContent')
<link rel="stylesheet" href="{{ asset('assets/css/main/table.css')}}">

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p class="fw-semibold fs-4">List Data Pesanan</p>
            </div>
            <div class="col-md-6 text-end align-self-center">
                <a href="{{ route('pesanan-action.create') }}" class="btn btn-primary mb-3">
                    <i class="fa-solid fa-plus"></i> Tambah Pesanan
                </a>
            </div>
        </div>
        <table id="PesanansTable" class="table table-bordered table-striped nowrap" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th style="width: 3%">No</th>
                    <th>Nama Produk</th>
                    <th>Gambar Produk</th>
                    <th>Nama Pengirim</th>
                    <th>Nomor Telepon</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $pesanan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pesanan->produk->nama_produk }}</td>
                        <td>
                            <img src="{{ asset('assets/img/Produk/' . $pesanan->produk->foto_1) }}" alt="{{ $pesanan->produk->nama_produk }}" width="100px" height="100px">
                        </td>
                        <td>{{ $pesanan->user->nama_lengkap }}</td>
                        <td>{{ $pesanan->user->no_telp }}</td>
                        <td>{{ $pesanan->jumlah }} Pcs</td>
                        <td>Rp. {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($pesanan->status == 'Pending')
                                <span class="badge bg-danger text-white w-75 py-2 px-3 text-center rounded">
                                    Belum Dikirim
                                </span>
                            @elseif ($pesanan->status == 'Dikirim')
                                <span class="badge bg-warning text-white w-75 py-2 px-3 text-center rounded">
                                    Sedang Dikirim
                                </span>
                            @else
                                <span class="badge bg-success text-white w-75 py-2 px-3 text-center rounded">
                                    Sudah Selesai
                                </span>
                            @endif
                        </td>
                        <td class="text-center gap-2  justify-content-center h-100">
                            <a href="{{ route('pesanan-action.edit', $pesanan->id) }}" class="text-decoration-none text-white btn btn-sm btn-warning">
                                <i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Edit</button>
                            </a>
                            <form class="d-inline form-delete-pesanan" data-url="{{ route('pesanan-action.destroy', $pesanan->id) }}">
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
<script src="{{ asset('assets/js/main/pesanan.js') }}"></script>
@endsection
