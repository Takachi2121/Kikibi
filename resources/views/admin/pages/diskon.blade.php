@extends('admin.main')

@section('title', 'Data Diskon')
@section('subtitle', 'Kelola data Diskon di sini.')

@section('mainContent')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus/dist/css/tempus-dominus.min.css">
<script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus/dist/js/tempus-dominus.min.js"></script>
<link rel="stylesheet" href="{{ asset('assets/css/main/table.css')}}">

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p class="fw-semibold fs-4">List Data Diskon</p>
            </div>
            <div class="col-md-6 text-end align-self-center">
                <button class="btn btn-primary mb-3"
                        data-bs-toggle="modal"
                        data-bs-target="#addDiskonModal">
                    <i class="fa-solid fa-plus"></i> Tambah Diskon
                </button>
            </div>
        </div>
        <table id="DiskonsTable" class="table table-bordered table-striped nowrap" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Foto</th>
                    <th class="text-center">Nama Produk</th>
                    <th class="text-center">Diskon</th>
                    <th class="text-center">Harga Akhir</th>
                    <th class="text-center">Tanggal Selesai</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $diskon)
                    <tr class="text-center align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td style="width: 1%">
                            <img src="{{ asset('assets/img/Produk/' . $diskon->produk->foto_1) }}" alt="Gambar Produk" width="120px" height="120px">
                        </td>
                        <td>{{ $diskon->produk->nama_produk }}</td>
                        <td>{{ $diskon->diskon }}%</td>
                        <td>Rp {{ number_format($diskon->harga_akhir, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($diskon->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm text-white btn-warning btn-edit"
                                data-id="{{ $diskon->id }}"
                                data-produk="{{ $diskon->produk->id }}"
                                data-makna-hadiah="{{ $diskon->makna_hadiah }}"
                            >
                                <i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Edit</button>
                            <form class="d-inline form-delete-kategori" data-url="{{ route('kategori-action.destroy', $diskon->id) }}">
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

<div class="modal fade" id="addDiskonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addKategoriForm" data-url="{{ route('kategori-action.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Produk</label>
                        <select name="produk" id="Produk" class="form-select">
                            <option value="" disabled selected hidden>Pilih Produk</option>
                            @foreach($produk as $item)
                                <option value="{{ $item->id }}" data-img="{{ asset('assets/img/Produk/' . $item->foto_1) }}">
                                    {{ $item->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Diskon</label>
                        <input type="number" name="diskon" id="diskon" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggalSelesai" class="form-control">
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="submit" id="btnTambahKategori" class="btn btn-danger w-100">
                        <span class="btn-text"><i class="fa-regular fa-floppy-disk"></i> Simpan Data</span>
                        <span class="btn-loading d-none"><span class="spinner-border spinner-border-sm"></span> Loading...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editKategoriModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editKategoriForm" method="POST" data-url="{{ route('kategori-action.update', 0) }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="idEdit">

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="namaKategoriEdit" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Makna Hadiah</label>
                        <textarea type="text" style="min-height: 20dvh" name="makna_hadiah" id="maknaHadiahEdit" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="w-100 d-flex justify-content-center">
                    <button type="submit" class="btn bg-danger py-2 mb-3 w-75" id="btnKategoriEdit">
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
<script src="{{ asset('assets/js/main/diskon.js') }}"></script>
@endsection
