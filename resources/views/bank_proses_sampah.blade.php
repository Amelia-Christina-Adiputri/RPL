@extends('layouts.main')
@section('title','Proses Sampah')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.bank_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">

        <br>

        <!-- PARAMETER KAPASITAS BANK -->
        <div class="card">
            <div class="card-header">
                <h5>Kapasitas Bank Sampah</h5>
            </div>
            <div class="card-body">
                <?php
                    $persen_organik = (($bank->kapasitas_organik_bank-$proses->last()->kapasitas_organik))/$bank->kapasitas_organik_bank*100;
                    $persen_anorganik = (($bank->kapasitas_anorganik_bank-$proses->last()->kapasitas_anorganik))/$bank->kapasitas_anorganik_bank*100;
                    $terisi_organik = $bank->kapasitas_organik_bank-$proses->last()->kapasitas_organik;
                    $terisi_anorganik = $bank->kapasitas_anorganik_bank-$proses->last()->kapasitas_anorganik;
                ?>

                <label>Sampah Organik</label>
                <div class="progress w-50">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo($persen_organik) ?>%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><?php echo($terisi_organik) ?> Kg</div>
                </div>
                <label>Sampah Anorganik</label>
                <div class="progress w-50">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo($persen_anorganik) ?>%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><?php echo($terisi_anorganik) ?> Kg</div>
                </div>
            </div>
        </div>

        <br>

        <!-- DAFTAR PROSES -->
        <div class="card">
             <div class="card-header">
                <h5>Daftar Proses</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Jenis Proses</th>
                        <th>Berat Organik</th>
                        <th>Berat Anorganik</th>
                        <th>Kapasitas Organik</th>
                        <th>Kapasitas Anorganik</th>
                    </tr>
                        @foreach($proses as $p)
                            <tr>
                                <td>{{$p->jenis_proses}}</td>
                                <td>{{$p->berat_organik}}</td>
                                <td>{{$p->berat_anorganik}}</td>
                                <td>{{$p->kapasitas_organik}}</td>
                                <td>{{$p->kapasitas_anorganik}}</td>
                            </tr>
                        @endforeach
                </table>

                <button class="btn btn-primary" role="button" data-toggle="modal" data-target="#tambah_proses">Tambah</button>

                </div>
            </div>

            <br>

    <!-- MODAL TAMBAH PROSES-->
    <div class="modal fade" id="tambah_proses" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambah_proses" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambah_prosesLabel">Tambah Proses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/bank_proses_sampah/insert" method="POST">
                    @csrf
                    <div class="form-group w-25">
                        <label>Proses</label>
                        <div class="form-check">
                            <input type="radio" name="proses" class="form-check-input" value="Penerimaan" checked><Label>Penerimaan</Label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="proses" class="form-check-input" value="Pengelolaan"><Label>Pengelolaan</Label>
                        </div>
                    </div>
                    <div class="form-group w-50">
                        <label>Petugas</label>
                            <select name="id_petugas" class="form-control">
                                <option value="">--Petugas--</option>
                                @foreach($petugas as $p)
                                    <option value="{{$p->id_pengguna}}">{{$p->nama}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group w-50">
                        <label>Pengguna</label>
                            <select name="id_pengguna" class="form-control">
                                <option value="">--Pengguna--</option>
                                @foreach($pengguna as $p)
                                    @if($p->id_pengguna!=null)
                                        <option value="{{$p->id_pengguna}}">{{$p->nama_pengguna}}</option>
                                    @endif
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group w-25">
                        <label>Organik</label>
                        <input type="number" name="organik" class="form-control" placeholder="Kg" required>
                    </div>
                    <div class="form-group w-25">
                        <label>Anorganik</label>
                        <input type="number" name="anorganik" class="form-control" placeholder="Kg" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
            </form>
        </div>
    </div>
@endsection
