@extends('layouts.main')
@section('title','Home')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.petugas_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">

        <br>

        <div class="card">
            <div class="card-header">
                <h5>Pengajuan Penerimaan</h5>
            </div>
            <div class="card-body">
                @if(count($pembuangan)!=null)
                    <!-- TABEL DAFTAR PENGAJUAN -->
                    <table class="table">
                        <tr>
                            <th>Nama Bank</th>
                            <th>Nama Pengguna</th>
                            <th>Sampah Organik</th>
                            <th>Sampah Anorganik</th>
                            <th>Detail</th>
                        </tr>
                        @foreach($pembuangan as $p)
                        <tr>
                            <td>{{$p->nama_bank}}</td>
                            <td>{{$p->nama_pggn}}</td>
                            <td>{{$p->total_organik}}</td>
                            <td>{{$p->total_anorganik}}</td>
                            <td><a href="/petugas_detail_ajukan_penerimaan/{{$p->id_bank}}/{{$p->id_pggn}}" class="btn btn-warning" role="button"><i class="bi bi-archive-fill"></i></a></td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <br>
                    <p>Tidak Terdapat Penerimaan yang Dapat Diajukan</p>
                @endif
            </div>
        </div>

        <br>

        <div class="card">
            <div class="card-header">
                <h5>Menunggu Pembayaran</h5>
            </div>
            <div class="card-body">
                @if(count($menungguPembayaran)!=null)
                    <!-- TABEL DAFTAR PENGAJUAN -->
                    <table class="table">
                        <tr>
                            <th>Nama Bank</th>
                            <th>Nama Pengguna</th>
                            <th>Sampah Organik</th>
                            <th>Sampah Anorganik</th>
                            <th>Detail</th>
                        </tr>
                        @foreach($menungguPembayaran as $p)
                        <tr>
                            <td>{{$p->nama_bank}}</td>
                            <td>{{$p->nama_pggn}}</td>
                            <td>{{$p->total_organik}}</td>
                            <td>{{$p->total_anorganik}}</td>
                            <td><a href="/petugas_detail_ajukan_penerimaan/{{$p->id_bank}}/{{$p->id_pggn}}/{{'false'}}" class="btn btn-warning" role="button"><i class="bi bi-archive-fill"></i></a></td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <br>
                    <p>Tidak Terdapat Penerimaan yang Menunggu Pembayaran</p>
                @endif
            </div>
        </div>

        <br>

        <div class="card">
            <div class="card-header">
                <h5>Riwayat Penerimaan</h5>
            </div>
            <div class="card-body">
                @if(count($riwayat)!=null)
                    <!-- TABEL DAFTAR PENGAJUAN -->
                    <table class="table">
                        <tr>
                            <th>Nama Bank</th>
                            <th>Nama Pengguna</th>
                            <th>Sampah Organik</th>
                            <th>Sampah Anorganik</th>
                            <th>Total Penerimaan</th>
                        </tr>
                        @foreach($riwayat as $r)
                        <tr>
                            <td>{{$r->nama_bank}}</td>
                            <td>{{$r->nama_pggn}}</td>
                            <td>{{$r->total_organik}}</td>
                            <td>{{$r->total_anorganik}}</td>
                            <td>{{$r->total_penerimaan}}</i></a></td>
                        </tr>
                        @endforeach
                    </table>
                @else
                    <br>
                    <p>Tidak Terdapat Riwayat Penerimaan</p>
                @endif
            </div>
        </div>
    </div>
@endsection
