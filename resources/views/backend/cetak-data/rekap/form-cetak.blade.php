@extends('backend.layouts.main')
@section('isi')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Cetak Data Kehilangan</h4>
                <div class="alert alert-success" role="alert">
                    <p class="fst-italic text-success">
                        Silahkan pilih tanggal untuk mencetak data kehilangan panen
                    </p>
                </div>

                <div class="form-group">

                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="bi-calendar-date input-group-text fs-4"></span>
                        </div>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            title="Enter search date" value="{{ old('start_date') }}" required autofocus />
                    </div>

                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="bi-calendar-date input-group-text fs-4"></span>
                        </div>
                        <input type="date" class="form-control" id="end_date" name="end_date" title="Enter search date"
                            value="{{ old('end_date') }}" required />
                    </div>

                    <a href=""
                        onclick="this.href='/dashboard/cetak-data/cetak-rekap/' + document.getElementById('start_date').value + '/' + document.getElementById('end_date').value"
                        target="_blank" class="btn btn-primary col-12">
                        <span class="bi-printer me-1"></span>
                        Cetak
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
