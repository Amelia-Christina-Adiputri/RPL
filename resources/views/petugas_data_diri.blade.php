@extends('layouts.main')
@section('title','Data Diri')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.petugas_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">

        <br>

        @if(session('alert'))
            @if(session('alert')=='Data telah berhasil diubah!')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{session('alert')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <br>
            @endif
        @endif

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
                    <tr>
                        <td>Lokasi</td>
                        <td> : </td>
                        <td></td>
                    </tr>
                </table>
                <div id="map" style="height: 250px"></div>
            </div>
            <div class="card-body">
                <a href="/petugas_ubah_data_diri"><button type="submit" role="button" class="btn btn-primary">Ubah</button>
            </div>
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
</script>
@endsection