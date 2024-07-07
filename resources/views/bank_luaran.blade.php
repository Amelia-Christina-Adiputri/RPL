@extends('layouts.main')
@section('title','Pengajuan Penerimaan')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border border">
        @include('layouts.bank_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">

    <!-- ALERT -->
    <div>
        @if(session('alert'))
            @if(session('alert')=='Tanggal awal harus lebih kecil atau sama dengan tanggal akhir!')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{session('alert')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        @endif
    </div>

    <br>

    <!-- Filter Data -->
    <div>
        <form action="/bank_luaran" method="GET">
            @csrf
            <label for="" class="mr-4">Tanggal Mulai</label>
            <label for="" class="ml-4">Tanggal Akhir</label> <br>
            <input type="date" id="tgl_awal" name="tgl_awal">
            <input type="date" id="tgl_akhir" name="tgl_akhir">
            <input type="submit" value="Filter">
        </form>
    </div>

    <br>
    <!-- TABEL DAFTAR PENGAJUAN -->
    <!-- DAFTAR PEMBUANGAN -->
    <div class="card">
        <div class="card-header">
            <h5>Daftar Pembuangan</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Nama Petugas</th>
                    <th>Harga Organik</th>
                    <th>Harga Anorganik</th>
                    <th>Tanggal Buang</th>
                    <th>Berat Organik</th>
                    <th>Berat Anorganik</th>
                </tr>
                    @foreach($pembuangan as $p)
                        <tr>
                            <td>{{$p->nama_pgs}}</td>
                            <td>{{$p->nama_plggn}}</td>
                            <td>{{$p->harga_organik}}</td>
                            <td>{{$p->harga_anorganik}}</td>
                            <td>{{$p->tgl_buang}}</td>
                            <td>{{$p->berat_organik}}</td>
                            <td>{{$p->berat_anorganik}}</td>
                        </tr>
                    @endforeach
            </table>
        </div>
    </div>

    <br>

    <!-- PENERIMAAN SAMPAH -->
    <div class="card">
        <div class="card-header">
            <h5>Penerimaan Sampah</h5>
        </div>
        <div class="card-body">
            <br>
            <!-- BAR CHART -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

                <script>
                    var total_organik = "<?php echo $totalSampah -> total_organik; ?>"
                    var total_anorganik = "<?php echo $totalSampah -> total_anorganik; ?>"
                    var xValues = ["Organik", "Anorganik"];
                    var yValues = [total_organik, total_anorganik, 0];
                    var barColors = ["green", "blue"];

                    new Chart("myChart", {
                        type: "bar",
                        data: {
                            labels: xValues,
                            datasets: [{
                            backgroundColor: barColors,
                            data: yValues
                            }]
                        },
                        options: {
                            legend: {display: false},
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
