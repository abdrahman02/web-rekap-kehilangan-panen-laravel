@extends('backend.layouts.main')
@section('isi')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Rekap Kehilangan</h5>

                <div class="alert alert-danger" role="alert">
                    <p class="fst-italic text-danger">
                        Harap hati-hati dalam mengelola data. menghapus salah satu data akan mempengaruhi data pada halaman
                        data rekap kehilangan.
                    </p>
                </div>


                <div class="search-bar gap-4 mb-3">
                    <form class="search-form d-flex align-items-center" method="GET" action="{{ route('rekap.index') }}">

                        <input type="date" class="form-control" name="start_date" title="Enter search date"
                            value="{{ old('start_date') }}" required autofocus />
                        <input type="date" class="form-control" name="end_date" title="Enter search date"
                            value="{{ old('end_date') }}" required />

                        <select class="form-select @error('kebun') is-invalid @enderror" id="kebun" name="kebun"
                            required>
                            <option selected> -- Pilih Kebun -- </option>
                            @foreach ($kebuns as $item)
                                @if (old('kebun') == $item->id)
                                    <option value="{{ $item->id }}" selected>{{ $item->nama_kebun }}
                                    </option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->nama_kebun }}</option>
                                @endif
                            @endforeach
                        </select>

                        <button type="submit" title="Search" class="btn btn-info text-white">
                            <i class="bi bi-search"></i>
                        </button>

                    </form>
                </div>
                <!-- End Search Bar -->


                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('success') }}
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

                <button type="button" class="btn btn-primary col-lg-8" data-bs-toggle="modal"
                    data-bs-target="#modal-tbh-item">
                    <i class="bi-plus-circle-dotted"></i>
                </button>

                <a href="{{ route('formCetakRekap') }}" target="_blank" class="btn btn-success col-lg-3">
                    <span class="bi-printer me-1"></span>
                    Cetak Rekap Kehilangan
                </a>

                <!-- Default Table -->
                @foreach ($rekaps as $namaKebun => $dataKebun)
                    <h2 class="card-title">Kebun : {{ $namaKebun }}</h2>
                    <table class="table table-responsive text-center">
                        @if ($kebuns->isNotEmpty())
                            @php $previousDate = null; @endphp
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Afdeling</th>
                                    <th>Jumlah Hilang</th>
                                    <th>Jumlah Selamat</th>
                                    <th>Ket</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $iteration = 0; @endphp
                                @foreach ($dataKebun as $item)
                                    <tr>
                                        @if ($previousDate !== $item->tanggal)
                                            @php $iteration++; @endphp
                                            <td rowspan="{{ $dataKebun->where('tanggal', $item->tanggal)->count() }}">
                                                {{ $iteration }}
                                            </td>
                                            <td rowspan="{{ $dataKebun->where('tanggal', $item->tanggal)->count() }}">
                                                {{ $item->tanggal }}
                                            </td>
                                            @php $previousDate = $item->tanggal; @endphp
                                        @endif
                                        <td>{{ $item->afdeling }}</td>
                                        <td>{{ $item->jumlah_hilang }}Kg</td>
                                        <td>{{ $item->jumlah_selamat }}Kg</td>
                                        <td class="text-wrap" style="width: 80px;">{{ Str::words($item->ket, 5) }}</td>
                                        <td class="text-center">
                                            <a class="badge badge-warning link-warning mx-2" title="Edit" href="#"
                                                data-bs-toggle="modal" data-bs-target="#modal-ubh-item{{ $item->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a class="badge badge-danger link-danger" title="Hapus" href="#"
                                                onclick="if(confirm('Apakah anda yakin?')) { event.preventDefault(); document.getElementById('delete-form{{ $item->id }}').submit()};">
                                                <i class="bi bi-trash"></i>
                                                <form action="{{ route('rekap.destroy', $item->id) }}" method="post"
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
                @endforeach
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
                    <form action="{{ route('rekap.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="kebun_id" class="col-sm-2 col-lg-12 col-form-label">Kebun</label>
                                <select class="form-select @error('kebun_id') is-invalid @enderror" id="kebun_id"
                                    name="kebun_id" required>
                                    <option selected> -- Pilih -- </option>
                                    @foreach ($kebuns as $item)
                                        @if (old('kebun_id') == $item->id)
                                            <option value="{{ $item->id }}" selected>{{ $item->nama_kebun }}
                                            </option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->nama_kebun }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="tanggal" class="col-sm-2 col-lg-12 col-form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal') }}" autofocus required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="afdeling" class="col-sm-2 col-lg-12 col-form-label">Afdeling</label>
                                <input type="text" name="afdeling" id="afdeling"
                                    class="form-control @error('afdeling') is-invalid @enderror"
                                    value="{{ old('afdeling') }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="jumlah_hilang" class="col-sm-2 col-lg-12 col-form-label">Jumlah Hilang
                                    (/Kg)</label>
                                <input type="text" name="jumlah_hilang" id="jumlah_hilang"
                                    class="form-control @error('jumlah_hilang') is-invalid @enderror"
                                    value="{{ old('jumlah_hilang') }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="jumlah_selamat" class="col-sm-2 col-lg-12 col-form-label">Jumlah
                                    Selamat (/Kg)</label>
                                <input type="text" name="jumlah_selamat" id="jumlah_selamat"
                                    class="form-control @error('jumlah_selamat') is-invalid @enderror"
                                    value="{{ old('jumlah_selamat') }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="ket" class="col-sm-2 col-lg-12 col-form-label">Keterangan</label>
                                <textarea class="form-control @error('ket') is-invalid @enderror" name="ket" id="ket"
                                    style="height: 100px" required>{{ old('ket') }}</textarea>
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
    @foreach ($rekaps as $namaKebun => $dataKebun)
        @foreach ($dataKebun as $item)
            @php
                $id = $item->id;
                $kebun_id = $item->kebun_id;
                $tanggal = $item->tanggal;
                $afdeling = $item->afdeling;
                $jumlah_hilang = $item->jumlah_hilang;
                $jumlah_selamat = $item->jumlah_selamat;
                $ket = $item->ket;
            @endphp
            <div class="modal fade" id="modal-ubh-item{{ $id }}" role="dialog" aria-hidden="true"
                tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Form Ubah Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('rekap.update', $id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="kebun_id" class="col-sm-2 col-lg-12 col-form-label">Kebun</label>
                                        <select class="form-select @error('kebun_id') is-invalid @enderror" id="kebun_id"
                                            name="kebun_id" required>
                                            <option selected> -- Pilih -- </option>
                                            @foreach ($kebuns as $item)
                                                @if (old('kebun_id', $kebun_id) == $item->id)
                                                    <option value="{{ $item->id }}" selected>{{ $item->nama_kebun }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->nama_kebun }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="tanggal" class="col-sm-2 col-lg-12 col-form-label">Tanggal</label>
                                        <input type="date" name="tanggal" id="tanggal"
                                            class="form-control @error('tanggal') is-invalid @enderror"
                                            value="{{ old('tanggal', $tanggal) }}" autofocus required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="afdeling" class="col-sm-2 col-lg-12 col-form-label">Afdeling</label>
                                        <input type="text" name="afdeling" id="afdeling"
                                            class="form-control @error('afdeling') is-invalid @enderror"
                                            value="{{ old('afdeling', $afdeling) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="jumlah_hilang" class="col-sm-2 col-lg-12 col-form-label">Jumlah Hilang
                                            (/Kg)
                                        </label>
                                        <input type="text" name="jumlah_hilang" id="jumlah_hilang"
                                            class="form-control @error('jumlah_hilang') is-invalid @enderror"
                                            value="{{ old('jumlah_hilang', $jumlah_hilang) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="jumlah_selamat" class="col-sm-2 col-lg-12 col-form-label">Jumlah
                                            Selamat (/Kg)</label>
                                        <input type="text" name="jumlah_selamat" id="jumlah_selamat"
                                            class="form-control @error('jumlah_selamat') is-invalid @enderror"
                                            value="{{ old('jumlah_selamat', $jumlah_selamat) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="ket" class="col-sm-2 col-lg-12 col-form-label">Keterangan</label>
                                        <textarea class="form-control @error('ket') is-invalid @enderror" name="ket" id="ket"
                                            style="height: 100px" required>{{ old('ket', $ket) }}</textarea>
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
    @endforeach
@endsection
