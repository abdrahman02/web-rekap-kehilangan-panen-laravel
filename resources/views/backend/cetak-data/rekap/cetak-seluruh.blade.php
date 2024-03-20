<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Rekap Kehilangan Berdasarkan Tanggal {{ $start_date }} - {{ $end_date }}</title>

    {{-- Template Main CSS --}}
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">

    {{-- Shortcut Icon --}}
    <link rel="shortcut icon" href="{{ asset('img/ptpn1.jpg') }}" type="image/x-icon">
</head>

<body class="my-2 mx-2">
    <div class="row">
        <div class="col-2 mt-3 ms-5">
            <img src="{{ asset('img/ptpn1.jpg') }}" alt="" style="max-height: 100px">
        </div>
        <div class="col-8">
            <h4 class="card-title mt-4 text-center fw-bold">REKAP KEHILANGAN PANEN</h4>
            <h4 class="card-title my-3 text-center fw-bold">PTPN 1 REGIONAL 1</h4>
            <h4 class="card-title text-center fw-bold">TANJUNG MORAWA</h4>
            <h6 class="card-title mt-3 text-center fw-bold">Tanggal : {{ $start_date }} - {{ $end_date }}</h4>
        </div>
    </div>
    <hr>
    <!-- Default Table -->
    @foreach ($items as $namaKebun => $dataKebun)
        <h2 class="card-title mt-3">Kebun : {{ $namaKebun }}</h2>
        <table class="table table-bordered table-responsive text-center">
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
                            <td class="text-wrap" style="width: 80px;">{{ $item->ket }}</td>
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

    <script>
        window.print();
    </script>
</body>

</html>
