<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Data Kebun</title>

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
            <h4 class="card-title mt-4 text-center fw-bold">DAFTAR KEBUN</h4>
            <h4 class="card-title my-3 text-center fw-bold">PTPN 1 REGIONAL 1</h4>
            <h4 class="card-title text-center fw-bold">TANJUNG MORAWA</h4>
        </div>
    </div>
    <hr>
    <!-- Default Table -->
    <table class="table table-bordered">
        @if ($items->isNotEmpty())
            <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th>Nama Rayon</th>
                    <th>Nama Kebun</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $key => $item)
                    <tr>
                        <th class="text-center" scope="row">{{ ++$key }}</th>
                        <td class="text-center">{{ $item->nama_rayon }}</td>
                        <td class="text-center">{{ $item->nama_kebun }}</td>
                    </tr>
                @endforeach
            </tbody>
        @else
            <div class="alert alert-primary text-center" role="alert">
                Data is empty, please add data first!!
            </div>
        @endif
    </table>
    <!-- End Default Table Example -->

    <script>
        window.print();
    </script>
</body>

</html>
