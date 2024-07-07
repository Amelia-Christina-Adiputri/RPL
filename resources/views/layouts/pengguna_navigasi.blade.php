<!-- NAVBAR -->
<div class="vh-100">
        <ul class="nav flex-column nav-pills mt-4">
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'pengguna_home') ? 'active':'' }}" href="/pengguna_home">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'pengguna_data_diri') ? 'active':'' }}" href="/pengguna_data_diri">Data Diri</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'pengguna_pilih_petugas') ? 'active':'' }}" href="/pengguna_pilih_petugas">Petugas Sampah</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'pengguna_pilih_bank') ? 'active':'' }}" href="/pengguna_pilih_bank">Tempat Pembuangan Sampah</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'pengguna_riwayat_transaksi') ? 'active':'' }}" href="/pengguna_riwayat_transaksi">Riwayat Transaksi</a>
        </li>
        </ul>
</div>
