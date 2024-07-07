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

        <!-- DATA DIRI -->
        <div class="card">
            <div class="card-header">
                <h5>Data Diri</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless w-auto">
                    <tr>
                        <td>Nama</td>
                        <td> : </td>
                        <td>{{$petugas->nama}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td> : </td>
                        <td>{{$petugas->alamat}}</td>
                    </tr>
                    <tr>
                        <td>Nomor Telpon</td>
                        <td> : </td>
                        <td>{{$petugas->telp}}</td>
                    </tr>
                    <tr>
                        <td>Kapasitas</td>
                        <td> : </td>
                        <td>{{$petugas->kapasitas_petugas}}</td>
                    </tr>
                    <tr>
                        <td>Tarif</td>
                        <td> : </td>
                        <td>{{$petugas->tarif_petugas}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <br>

        <!-- DAFTAR PENGAJUAN -->
            <div class="card">
                <div class="card-header">
                    <h5>Daftar Titik Jemput</h5>
                </div>
                <div class="card-body">
                    <!-- MAPS -->
                    <div id="map" style="height: 250px"></div>

                    @if(count($pengajuan)!=null)
                        <table class="table">
                            <tr>
                                <th>Nama Pengguna</td>
                                <th>Alamat</td>
                                <th>Nomor Telepon</td>
                                <th>Aksi</th>
                            </tr>
                                @foreach($pengajuan as $p)
                                    <tr>
                                        <td>{{$p->nama}}</td>
                                        <td>{{$p->alamat}}</td>
                                        <td>{{$p->telp}}</td>
                                        <td>
                                            <a href="/petugas_home/terima_psp/{{$p->id_trans_psp}}" class="btn btn-success" role="button"><i class="bi bi-check-square"></i></a>
                                            <a onclick="return confirm('Apakah anda yakin ingin menolak?')" href="/petugas_home/tolak_psp/{{$p->id_trans_psp}}" class="btn btn-danger" role="button"><i class="bi bi-x-square"></i></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                    @else
                        <br>
                        <p>Tidak Terdapat Pengajuan</p>
                    @endif
                </div>
            </div>

        <br>

        <!-- DAFTAR PENGAJUAN BELUM TERBAYAR -->

            <div class="card">
                <div class="card-header">
                    <h5>Daftar Pengajuan Belum Terbayar</h5>
                </div>
                <div class="card-body">
                    @if(count($pembayaran)!=null)
                        <table class="table">
                            <tr>
                                <th>Nama Pengguna</td>
                                <th>Alamat</td>
                                <th>Nomor Telepon</td>
                                <th>Bukti Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                                @foreach($pembayaran as $p)
                                    <tr>
                                        <td>{{$p->nama}}</td>
                                        <td>{{$p->alamat}}</td>
                                        <td>{{$p->telp}}</td>
                                        @if($p->bukti_pembayaran != NULL)
                                        <td>
                                            <button class="btn btn-warning" role="button" data-toggle="modal" data-target="#bukti_pembayaran">Bukti Pembayaran</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="bukti_pembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Bukti Pembayaran</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="image">
                                                        <img class="modal-content" style="height:100%;max-width:400px" src="{{ url('/pengguna_bukti_bayar/'.$p->bukti_pembayaran) }}" alt="">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                        </td>
                                        @else
                                        <td></td>
                                        @endif
                                        <td>
                                            <a href="/petugas_home/pembayaran_psp/{{$p->id_trans_psp}}" class="btn btn-success" role="button">Verifikasi Pembayaran</a>
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                    @else
                        <br>
                        <p>Tidak Terdapat Pengajuan yang Belum Terbayar</p>
                    @endif
                </div>
            </div>


@endsection

@section('maps')
<script>
    // CUSTOM MARKER
    var myIcon = L.icon({
        iconUrl: 'https://cdn0.iconfinder.com/data/icons/perfico-basic-essentials/64/Pin-512.png',
        iconSize: [50, 50],
        iconAnchor: [25, 50],
        popupAnchor: [-3, -60]
    });

    var petugasIcon = L.icon({
        iconUrl: 'https://cdn1.iconfinder.com/data/icons/logistics-delivery-set-3/512/29-512.png',
        iconSize: [50, 50],
        iconAnchor: [25, 50],
        popupAnchor: [-3, -60]
    });

    var penggunaIcon = L.icon({
        iconUrl: 'https://cdn1.iconfinder.com/data/icons/logistics-delivery-set-3/512/30-512.png',
        iconSize: [50, 50],
        iconAnchor: [25, 50],
        popupAnchor: [-3, -60]
    });

    var bankIcon = L.icon({
        iconUrl: 'https://cdn1.iconfinder.com/data/icons/logistics-delivery-set-3/512/32-512.png',
        iconSize: [50, 50],
        iconAnchor: [25, 50],
        popupAnchor: [-3, -60]
    });

    // Initialize the map
    var map = L.map('map').setView([0, 0], 30);

    // Add a basemap (e.g., OpenStreetMap)
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Add a marker to the all destinations
    var locations = <?php echo json_encode($petugas); ?>;
    console.log(locations);
    if(locations.latitude != null && locations.longitude != null)
    {
        // looping for create marker per location
        L.marker([locations.latitude, locations.longitude], {icon : myIcon}).addTo(map).bindPopup("You're Here!").openPopup();
        map.setView([locations.latitude, locations.longitude], 18);
    }else{
        // Get the user's geolocation and add a marker
        navigator.geolocation.getCurrentPosition(function(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        map.setView([lat, lon], 18);
        var userLocation = L.marker([lat, lon], {icon : myIcon}).addTo(map);
        userLocation.bindPopup('You are here!').openPopup();
    });
    }

    var locations_pengajuan = <?php echo json_encode($pengajuan); ?>;
        locations_pengajuan.forEach(e => {
        L.marker([e.latitude,
        e.longitude], {icon : penggunaIcon}).addTo(map).bindPopup(e.nama);
    });

    var locations_pengajuan = <?php echo json_encode($langganan); ?>;
        locations_pengajuan.forEach(e => {
        L.marker([e.latitude,
        e.longitude], {icon : penggunaIcon}).addTo(map).bindPopup(e.nama);
    });

    var locations_pengajuan = <?php echo json_encode($pembayaran); ?>;
        locations_pengajuan.forEach(e => {
        L.marker([e.latitude,
        e.longitude], {icon : penggunaIcon}).addTo(map).bindPopup(e.nama);
    });
</script>
@endsection
