@extends('layouts.main')
@section('title','Titik Jemput Tidak Langganan')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.petugas_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">

        <br>
        <!-- MAPS -->
        <div id="map" style="height: 250px"></div>

        <br>

        <!-- DAFTAR PENGAMBILAn -->
        <div class="card">
            <div class="card-body">
                <h5>Daftar Pengambilan</h5>
                <table class="table">
                    <tr>
                        <th>Nama Pengguna</td>
                        <th>Alamat</td>
                        <th>Nomor Telepon</td>
                    </tr>
                    @foreach($pengajuan as $p)
                        <tr>
                            <td>{{$p->nama}}</td>
                            <td>{{$p->alamat}}</td>
                            <td>{{$p->telp}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection

@section('maps')
<script type="text/javascript" src="../js/map.js"></script>
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
    // looping for create marker per location
        L.marker([locations.latitude, locations.longitude], {icon : myIcon}).addTo(map).bindPopup("You're Here!").openPopup();
        map.setView([locations.latitude, locations.longitude], 18);

        var locations_bank = <?php echo json_encode($pengajuan); ?>;
        locations_bank.forEach(e => {
        L.marker([e.latitude,
        e.longitude], {icon : penggunaIcon}).addTo(map).bindPopup(e.nama);
        });
</script>


@endsection
