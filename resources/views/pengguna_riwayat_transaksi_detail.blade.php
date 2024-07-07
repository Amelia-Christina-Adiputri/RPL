<!-- BODY -->
<center><h2><img src="https://i.ibb.co/Vq8PDQb/LOGO-1.png" alt="" width="30" height="30"><span>DIPOTECH</span></h2></center>
<center><h1>Pembayaran Iuran Bulanan</h1></center>

<hr>

<br>

<table class="table table-borderless">
    <tr>
        <td>Tanggal Transaksi</td>
        <td> : </td>
        <td>{{$psp->tgl_pembayaran_psp}}</td>
    </tr>
    <tr>
        <td>Nama Petugas</td>
        <td> : </td>
        <td>{{$psp->nama_petugas}}</td>
    </tr>
    <tr>
        <td>Nama Pelanggan</td>
        <td> : </td>
        <td>{{$psp->nama_pengguna}}</td>
    </tr>
    <tr>
        <td>Total Pembayaran</td>
        <td> : </td>
        <td>{{$psp->iuran}}</td>
    </tr>
</table>
