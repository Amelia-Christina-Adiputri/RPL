@extends('layouts.main')
@section('title','Validasi Pengajuan Pembuangan')
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
                <h5>Validasi Pengajuan Penerimaan</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Waktu Pendaftaran</th>
                        <th>Aksi</th>
                    </tr>
                    @if(isset($pendaftaran))
                        @foreach($pendaftaran as $p)
                            <tr>
                                <td>{{$p->nama}}</td>
                                <td>{{$p->role}}</td>
                                <td>{{$p->tgl_trans_pbs}}</td>
                                <td>
                                    <a href="/bank_validasi_pengajuan_pembuangan/terima_pbs/{{$p->id_trans_pbs}}" class="btn btn-success" role="button"><i class="bi bi-check-square"></i></a>
                                    <a onclick="return confirm('Apakah anda yakin ingin menolak?')" href="/bank_validasi_pengajuan_pembuangan/tolak_pbs/{{$p->id_trans_pbs}}" class="btn btn-danger" role="button"><i class="bi bi-x-square"></i></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>

        <br>

        <!-- TABEL DAFTAR PENGAJUAN SUDAH VALID -->
        <div class="card">
            <div class="card-header">
                <h5>Daftar Penerimaan</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Nama</th>
                        <th>Role</th>
                    </tr>
                    @if(isset($terdaftar))
                        @foreach($terdaftar as $t)
                            <tr>
                                <td>{{$t->nama}}</td>
                                <td>{{$t->role}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection
