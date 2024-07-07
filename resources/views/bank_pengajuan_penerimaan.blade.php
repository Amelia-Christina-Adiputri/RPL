@extends('layouts.main')
@section('title','Pengajuan Penerimaan')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.bank_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">
        <br>
         <!-- TABEL DAFTAR PENGAJUAN -->
         <div class="card">
            <div class="card-header">
                <h5>Pengajuan Penerimaan</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Nama Petugas</th>
                        <th>Nama Pengguna</th>
                        <th>Sampah Organik</th>
                        <th>Sampah Anorganik</th>
                        <th>Detail</th>
                    </tr>
                    @foreach($pembuangan as $p)
                    <tr>
                        <td>{{$p->nama_pgs}}</td>
                        <td>{{$p->nama_plggn}}</td>
                        <td>{{$p->total_organik}}</td>
                        <td>{{$p->total_anorganik}}</td>
                        <td><a href="/bank_detail_pengajuan_penerimaan/{{$p->id_pgs}}/{{$p->id_pggn}}" class="btn btn-warning" role="button"><i class="bi bi-archive-fill"></i></a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <br>

        <div class="card">
            <div class="card-header">
                <h5>Riwayat Pembayaran  Penerimaan</h5>
            </div>
            <div class="card-body">
                @if(count($riwayat)!=null)
                    <!-- TABEL DAFTAR PENGAJUAN -->
                    <table class="table">
                        <tr>
                            <th>Nama Petugas</th>
                            <th>Nama Pengguna</th>
                            <th>Sampah Organik</th>
                            <th>Sampah Anorganik</th>
                            <th>Total Penerimaan</th>
                        </tr>
                        @foreach($riwayat as $r)
                        <tr>
                            <td>{{$r->nama_petugas}}</td>
                            <td>{{$r->nama_pggn}}</td>
                            <td>{{$r->total_organik}}</td>
                            <td>{{$r->total_anorganik}}</td>
                            <td>{{$r->total_penerimaan}}</i></a></td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <br>
                    <p>Tidak Terdapat Riwayat Pembayaran</p>
                @endif
            </div>
        </div>
    </div>

@endsection
