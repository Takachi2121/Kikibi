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
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPesananModal"><i class="fa-solid fa-plus"></i> Tambah Pesanan</button></button>
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
                            <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editPesananModal"
                            data-id="{{ $pesanan->id }}"
                            data-produk-id="{{ $pesanan->produk_id }}"
                            data-pengirim-id="{{ $pesanan->user_id }}"
                            data-nama-penerima="{{ $pesanan->nama_penerima }}"
                            data-alamat-penerima="{{ $pesanan->alamat_penerima }}"
                            data-jumlah="{{ $pesanan->jumlah }}"
                            data-status="{{ $pesanan->status }}"
                            >
                                <i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Edit
                            </button>
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

<div class="modal fade" id="addPesananModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tambahPesananForm" method="POST" data-url="{{ route('pesanan-action.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <select name="produk_id" id="produkIdTambah" class="form-control">
                            <option value="" disabled selected hidden>Pilih Produk</option>
                            @foreach($produk as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Pengirim</label>
                        <select name="user_id" id="pengirimIdTambah" class="form-control">
                            <option value="" disabled selected hidden>Pilih Pengirim</option>
                            @foreach($users as $pengirim)
                                <option value="{{ $pengirim->id }}">{{ $pengirim->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" name="nama_penerima" id="namaPenerimaTambah" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Penerima</label>
                        <input type="text" name="alamat_penerima" id="alamatPenerimaTambah" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlahTambah" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="statusTambah" class="form-control">
                            <option value="" disabled selected hidden>Pilih Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Dikirim">Dikirim</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="btnTambahPesanan" class="btn btn-danger w-100">
                        <span class="btn-text"><i class="fa-regular fa-floppy-disk"></i> Simpan Data</span>
                        <span class="btn-loading d-none"><span class="spinner-border spinner-border-sm"></span> Loading...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Pesanan -->
<div class="modal fade" id="editPesananModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editPesananForm" method="POST" data-url="{{ route('pesanan-action.update', 0) }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                    <div class="modal-body">
                        <input type="hidden" name="id" id="idEdit">

                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <select name="produk_id" id="produkIdEdit" class="form-control">
                                <option value="" disabled selected hidden>Pilih Produk</option>
                                @foreach($produk as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Pengirim</label>
                            <select name="user_id" id="pengirimIdEdit" class="form-control">
                                <option value="" disabled selected hidden>Pilih Pengirim</option>
                                @foreach($users as $pengirim)
                                    <option value="{{ $pengirim->id }}">{{ $pengirim->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="nama_penerima" id="namaPenerimaEdit" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Penerima</label>
                            <input type="text" name="alamat_penerima" id="alamatPenerimaEdit" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlahEdit" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="statusEdit" class="form-control">
                                <option value="" disabled selected hidden>Pilih Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>

                <div class="w-100 d-flex justify-content-center">
                    <button type="submit" class="btn bg-danger py-2 mb-3 w-75" id="btnPesananEdit">
                        <span class="btn-text text-white">
                            <i class="fa-solid fa-rotate"></i>&nbsp;&nbsp;Perbarui Data
                        </span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm"></span>
                            Loading...
                        </span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('js-admin')
<script src="{{ asset('assets/js/main/pesanan.js') }}"></script>
@endsection
