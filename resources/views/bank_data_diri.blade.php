@extends('layouts.main')
@section('title','Data Diri')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.bank_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">
        <!-- DATA BANK -->
        <br>
        <div class="card">
            <div class="card-header">
                <h5>Data Diri</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless w-auto">
                    <tr>
                        <td>Nama</td>
                        <td> : </td>
                        <td>{{$bank->nama}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td> : </td>
                        <td>{{$bank->alamat}}</td>
                    </tr>
                    <tr>
                        <td>Nomor Telpon</td>
                        <td> : </td>
                        <td>{{$bank->telp}}</td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td> : </td>
                        <td>{{$bank->email}}</td>
                    </tr>
                    <tr>
                        <td>Kapasitas Organik</td>
                        <td> : </td>
                        <td>{{$bank->kapasitas_organik_bank}}</td>
                    </tr>
                    <tr>
                        <td>Kapasitas Anorganik</td>
                        <td> : </td>
                        <td>{{$bank->kapasitas_anorganik_bank}}</td>
                    </tr>
                    <tr>
                        <td>Lokasi</td>
                        <td> : </td>
                    </tr>
                </table>
                <div id="map" style="height: 250px"></div>
            </div>
            <div class="card-body">
                <a href="/bank_ubah_data_diri"><button type="button" role="button" class="btn btn-primary">Ubah</button></a>
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

        // Initialize the map
        var map = L.map('map').setView([0, 0], 30);

        // Add a basemap (e.g., OpenStreetMap)
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Add a marker to the all destinations
        var locations = <?php echo json_encode($bank); ?>;

        // console.log(locations);
        if(locations.latitude != null && locations.longitude != null)
        {
            // looping for create marker per location
            L.marker([locations.latitude, locations.longitude], {icon : myIcon}).addTo(map).bindPopup('You are here!').openPopup();
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
