@extends('layouts.main')
@section('title','Detail Pengajuan Penerimaan')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.bank_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">

        <!-- JUDUL -->
        <h1 class="mt-4">Detail Pengajuan Penerimaan</h1>

        <!-- TABEL DAFTAR PENGAJUAN -->
        <table class="table table-bordered">
            <thead>
                <tr>
                <th scope="col">Tanggal Pembuangan</th>
                <th scope="col">Sampah Organik</th>
                <th scope="col"> Harga Sampah Organik</th>
                <th scope="col">Sampah Anorganik</th>
                <th scope="col">Harga Sampah Anorganik</th>
                </tr>
            </thead>
            <tbody>
                @foreach($harga as $h)
                <tr>
                    <td>{{$h->tgl_buang}}</td>
                    <td>{{$h->berat_organik}}</td>
                    <td>{{$h->harga_organik}}</td>
                    <td>{{$h->berat_anorganik}}</td>
                    <td>{{$h->harga_anorganik}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4">Total Harga Sampah Organik</td>
                    <td>{{$total->total_harga_organik}}</td>
                </tr>
                <tr>
                    <td colspan="4">Total Harga Sampah Anorganik</td>
                    <td>{{$total->total_harga_anorganik}}</td>
                </tr>
                <tr>
                    <td colspan="4">Total Penerimaan</td>
                    <td>{{$total->total_penerimaan}}</td>
                </tr>
            </tbody>
        </table>
    <div>
        <a type="button" href="/bank_detail_pengajuan_penerimaan/bayar/{{$total->id_petugas}}/{{$total->id_pengguna}}" class="btn btn-primary" id="btn_bayar">Bayar</a>
    </div>
@endsection
