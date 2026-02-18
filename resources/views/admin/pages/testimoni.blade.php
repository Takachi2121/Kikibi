@extends('admin.main')

@section('title', 'Data Testimoni')
@section('subtitle', 'Kelola data Testimoni di sini.')

@section('mainContent')
<link rel="stylesheet" href="{{ asset('assets/css/main/table.css')}}">

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p class="fw-semibold fs-4">List Data Testimoni</p>
            </div>
            <div class="col-md-6 text-end align-self-center">
                <button class="btn btn-primary mb-3"
                        data-bs-toggle="modal"
                        data-bs-target="#addTestimoniModal">
                    <i class="fa-solid fa-plus"></i> Tambah Testimoni
                </button>
            </div>
        </div>
        <table id="TestimonisTable" class="table table-bordered table-striped nowrap" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Foto Testimoni</th>
                    <th>Nama Testimoni</th>
                    <th>Isi Testimoni</th>
                    <th>Rating</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $testimoni)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($testimoni->foto)
                                <img src="{{ asset('assets/img/Testimoni/' . $testimoni->foto) }}" alt="Foto Testimoni" class="img-thumbnail" style="max-width: 100px;">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                        <td>{{ $testimoni->nama }}</td>
                        <td>{{ Str::limit($testimoni->komentar, 100) }}</td>
                        <td class="text-center">
                            <span class="d-none">{{ $testimoni->rating }}</span>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $testimoni->rating)
                                    <i class="fa-solid fa-star fa-2x text-warning"></i>
                                @else
                                    <i class="fa-regular fa-star fa-2x text-warning"></i>
                                @endif
                            @endfor
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm text-white btn-warning btn-edit"
                                data-id="{{ $testimoni->id }}"
                                data-nama="{{ $testimoni->nama }}"
                                data-komentar="{{ $testimoni->komentar }}"
                                data-rating="{{ $testimoni->rating }}"
                                data-foto="{{ $testimoni->foto }}"
                            >
                                <i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Edit</button>
                            <form class="d-inline form-delete-testimoni" data-url="{{ route('testimoni-action.destroy', $testimoni->id) }}">
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

<div class="modal fade" id="addTestimoniModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addTestimoniForm" data-url="{{ route('testimoni-action.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Testimoni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Testimoni</label>
                        <input type="text" name="nama" id="namaTestimoniTambah" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <input type="number" name="rating" id="ratingTambah" class="form-control" min="1" max="5">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Komentar</label>
                        <textarea type="text" style="min-height: 20dvh" name="komentar" id="komentarTambah" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Testimoni</label>
                        <img id="previewFotoTambah" src="#" alt="Preview Foto" class="img-thumbnail mb-2 d-none" style="max-width: 150px;">
                        <input type="file" name="foto" id="fotoTambah" accept=".jpg, .png, .jpeg" class="form-control">
                    </div>
                    <script>
                        document.getElementById('fotoTambah').addEventListener('change', function (event) {
                            const [file] = this.files;
                            if (file) {
                                const preview = document.getElementById('previewFotoTambah');
                                preview.src = URL.createObjectURL(file);
                                preview.classList.remove('d-none');
                            }
                        });
                    </script>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="btnTambahTestimoni" class="btn btn-danger w-100">
                        <span class="btn-text"><i class="fa-regular fa-floppy-disk"></i> Simpan Data</span>
                        <span class="btn-loading d-none"><span class="spinner-border spinner-border-sm"></span> Loading...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editTestimoniModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editTestimoniForm" method="POST" data-url="{{ route('testimoni-action.update', 0) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Testimoni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="idEdit">

                    <div class="mb-3">
                        <label class="form-label">Nama Testimoni</label>
                        <input type="text" name="nama" id="namaTestimoniEdit" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <input type="number" name="rating" id="ratingEdit" class="form-control" min="1" max="5">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Komentar</label>
                        <textarea type="text" style="min-height: 20dvh" name="komentar" id="komentarEdit" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Testimoni</label>
                        <img id="previewFotoEdit" src="#" alt="Preview Foto" class="img-thumbnail mb-2 d-none" style="max-width: 150px;">
                        <input type="file" name="foto" id="fotoEdit" accept=".jpg, .png, .jpeg" class="form-control">
                    </div>
                    <script>
                        document.getElementById('fotoEdit').addEventListener('change', function (event) {
                            const [file] = this.files;
                            if (file) {
                                const preview = document.getElementById('previewFotoEdit');
                                preview.src = URL.createObjectURL(file);
                                preview.classList.remove('d-none');
                            }
                        });
                    </script>

                </div>

                <div class="w-100 d-flex justify-content-center">
                    <button type="submit" class="btn bg-danger py-2 mb-3 w-75" id="btnTestimoniEdit">
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
<script src="{{ asset('assets/js/main/testimoni.js') }}"></script>
@endsection
