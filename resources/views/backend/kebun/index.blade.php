@extends('backend.layouts.main')
@section('isi')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Kebun</h5>

                <div class="alert alert-danger" role="alert">
                    <p class="fst-italic text-danger">
                        Harap hati-hati dalam mengelola data. menghapus salah satu data akan mempengaruhi data pada halaman
                        data rekap kehilangan.
                    </p>
                </div>


                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Alert Error --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="button" class="btn btn-primary col-lg-9" data-bs-toggle="modal"
                    data-bs-target="#modal-tbh-item">
                    <i class="bi-plus-circle-dotted"></i>
                </button>
                <a href="{{ route('cetakKebun') }}" target="_blank" class="btn btn-success col-lg-2">
                    <span class="bi-printer me-1"></span>
                    Cetak Kebun
                </a>

                <!-- Default Table -->
                <table class="table table-responsive text-center">
                    @if ($kebuns->isNotEmpty())
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Rayon</th>
                                <th>Nama Kebun</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kebuns as $key => $item)
                                <tr>
                                    <th scope="row">{{ $kebuns->firstItem() + $key }}</th>
                                    <td>{{ $item->nama_rayon }}</td>
                                    <td>{{ $item->nama_kebun }}</td>
                                    <td class="text-center">
                                        <a class="badge badge-warning link-warning mx-2" title="Edit" href="#"
                                            data-bs-toggle="modal" data-bs-target="#modal-ubh-item{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="badge badge-danger link-danger" title="Hapus" href="#"
                                            onclick="if(confirm('Apakah anda yakin?')) {
                                event.preventDefault(); document.getElementById('delete-form{{ $item->id }}').submit()};">
                                            <i class="bi bi-trash"></i>
                                            <form action="{{ route('kebun.destroy', $item->id) }}" method="post"
                                                id="delete-form{{ $item->id }}" class="d-none">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                        <div class="alert alert-primary text-center" role="alert">
                            Data is empty, please add data first!!
                        </div>
                    @endif
                </table>
                <div class="d-flex justify-content-center">
                    {{ $kebuns->links() }}
                </div>
                <!-- End Default Table Example -->
            </div>
        </div>
    </div>

    {{-- Modal Tambah Data --}}
    <div class="modal fade" id="modal-tbh-item" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('kebun.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="nama_rayon" class="col-sm-2 col-lg-12 col-form-label">Nama Rayon</label>
                                <input type="text" name="nama_rayon" id="nama_rayon"
                                    class="form-control @error('nama_rayon') is-invalid @enderror"
                                    value="{{ old('nama_rayon') }}" autofocus required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="nama_kebun" class="col-sm-2 col-lg-12 col-form-label">Nama Kebun</label>
                                <input type="text" name="nama_kebun" id="nama_kebun"
                                    class="form-control @error('nama_kebun') is-invalid @enderror"
                                    value="{{ old('nama_kebun') }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Tambah Data</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                    aria-label="Close">Batal</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Ubah Data --}}
    @foreach ($kebuns as $item)
        @php
            $id = $item->id;
            $nama_rayon = $item->nama_rayon;
            $nama_kebun = $item->nama_kebun;
        @endphp
        <div class="modal fade" id="modal-ubh-item{{ $id }}" role="dialog" aria-hidden="true"
            style="overflow: hidden;" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Ubah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('kebun.update', $id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <label for="nama_rayon" class="col-sm-2 col-lg-12 col-form-label">Nama Rayon</label>
                                    <input type="text" name="nama_rayon" id="nama_rayon"
                                        class="form-control @error('nama_rayon') is-invalid @enderror"
                                        value="{{ old('nama_rayon', $nama_rayon) }}" autofocus required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <label for="nama_kebun" class="col-sm-2 col-lg-12 col-form-label">Nama Kebun</label>
                                    <input type="text" name="nama_kebun" id="nama_kebun"
                                        class="form-control @error('nama_kebun') is-invalid @enderror"
                                        value="{{ old('nama_kebun', $nama_kebun) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-success">Ubah Data</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                        aria-label="Close">Batal</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
