<!-- NAVBAR -->
<div class="vh-100">
    <ul class="nav flex-column nav-pills mt-4"  id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'bank_home') ? 'active':'' }}" href="/bank_home">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'bank_data_diri') ? 'active':'' }}" href="/bank_data_diri">Data Diri</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'bank_validasi_pengajuan_pembuangan') ? 'active':'' }}" href="/bank_validasi_pengajuan_pembuangan">Validasi Pengajuan Pembuangan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'bank_pengajuan_penerimaan') ? 'active':'' }}" href="/bank_pengajuan_penerimaan">Pengajuan Penerimaan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'bank_proses_sampah') ? 'active':'' }}" href="/bank_proses_sampah">Proses Sampah</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($key == 'bank_luaran') ? 'active':'' }}" href="/bank_luaran">Luaran Bank Sampah</a>
        </li>
    </ul>
</div>
