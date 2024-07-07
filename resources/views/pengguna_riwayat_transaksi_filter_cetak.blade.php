<center><h2><img src="https://i.ibb.co/Vq8PDQb/LOGO-1.png" alt="" width="30" height="30"><span>DIPOTECH</span></h2></center>
<center><h1>Riwayat Transaksi</h1></center>

<hr>

<!-- DAFTAR PSP -->
<h2>Riwayat Transaksi Pembayaran</h2>
@if(count($psp)!=null)
    <table border="1">
        <tr>
            <th>Nama Petugas</td>
            <th>Iuran</td>
            <th>Tanggal Transaksi</td>
        </tr>
            @foreach($psp as $p)
                <tr>
                    <td>{{$p->nama}}</td>
                    <td>{{$p->iuran}}</td>
                    <td>{{$p->tgl_pembayaran_psp}}</td>
                </tr>
            @endforeach
    </table>
@else
    <br>
    <p>Tidak Terdapat Pengajuan</p>
@endif

<br>

<!-- DAFTAR PEMBUANGAN -->

<h2>Riwayat Pembuangan</h2>
@if(count($pembuangan)!=null)
    <table border="1">
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
