@extends('layouts.main')
@section('title','Home')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.pengguna_navigasi')
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
            <form action="/pengguna_riwayat_transaksi" method="GET">
                @csrf
                <label for="" class="mr-4">Tanggal Mulai</label>
                <label for="" class="ml-4">Tanggal Akhir</label> <br>
                <input type="date" id="tgl_awal" name="tgl_awal">
                <input type="date" id="tgl_akhir" name="tgl_akhir">
                <input type="submit" value="Filter">
            </form>
        </div>

        <br>

        <div class="float-right"><a href="/pengguna_riwayat_transaksi_filter_cetak/{{$tgl_awal}}/{{$tgl_akhir}}" class="btn btn-primary" role="button"><i class="bi bi-printer"></i> Cetak Riwayat Transaksi</a></div>

        <br><br>

        <!-- DAFTAR PSP -->
        <div class="card">
            <div class="card-header">
                <h5>Riwayat Transaksi Pembayaran</h5>
            </div>
            <div class="card-body">
                @if(count($psp)!=null)
                    <table class="table">
                        <tr>
                            <th>Nama Petugas</td>
                            <th>Iuran</td>
                            <th>Tanggal Transaksi</td>
                            <th>Cetak Invoice</th>
                        </tr>
                            @foreach($psp as $p)
                                <tr>
                                    <td>{{$p->nama}}</td>
                                    <td>{{$p->iuran}}</td>
                                    <td>{{$p->tgl_pembayaran_psp}}</td>
                                    <td><a href="/pengguna_riwayat_transaksi/cetak/{{$p->id_trans_psp}}" class="btn btn-primary" role="button"><i class="bi bi-printer"></i> Cetak</a></td>
                                </tr>
                            @endforeach
                    </table>
                @else
                    <br>
                    <p>Tidak Terdapat Pengajuan</p>
                @endif
            </div>
        </div>

        <br>

        <!-- DAFTAR PEMBUANGAN -->
        <div class="card">
            <div class="card-header">
                <h5>Riwayat Pembuangan</h5>
            </div>
            <div class="card-body">
                @if(count($pembuangan)!=null)
                    <table class="table">
                        <tr>
                            <th>Nama Bank</td>
                            <th>Tanggal Pembuangan</td>
                            <th>Berat Organik</td>
                            <th>Berat Anorganik</th>
                        </tr>
                            @foreach($pembuangan as $p)
                                <tr>
                                    <td>{{$p->nama}}</td>
                                    <td>{{$p->tgl_buang}}</td>
                                    <td>{{$p->berat_organik}}</td>
                                    <td>{{$p->berat_anorganik}}</td>
                                </tr>
                            @endforeach
                    </table>
                @else
                    <br>
                    <p>Tidak Terdapat Pengajuan</p>
                @endif
            </div>
        </div>
    </div>


@endsection
