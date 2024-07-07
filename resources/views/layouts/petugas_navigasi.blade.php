<!-- NAVBAR -->
<div class=" vh-100">
    <ul class="nav flex-column nav-pills mt-4">
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'petugas_home') ? 'active':'' }}" href="/petugas_home">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'petugas_data_diri') ? 'active':'' }}" href="/petugas_data_diri">Data Diri</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" href="">Titik Penjemputan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link ml-3 {{ ($key == 'petugas_titik_jemput_langganan') ? 'active':'' }}" href="/petugas_titik_jemput_langganan">Berlangganan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link ml-3 {{ ($key == 'petugas_titik_jemput_tidak_langganan') ? 'active':'' }}" href="/petugas_titik_jemput_tidak_langganan">Tidak Berlangganan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'petugas_daftar_bank') ? 'active':'' }}" href="/petugas_daftar_bank">Bank Sampah</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'petugas_ajukan_penerimaan') ? 'active':'' }}" href="/petugas_ajukan_penerimaan">Ajukan Penerimaan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'petugas_luaran') ? 'active':'' }}" href="/petugas_luaran">Luaran</a>
        </li>
    </ul>
</div>
