@extends('layouts.main')
@section('title','Home')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.bank_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">

        <br>

        <!-- DATA BANK -->
        <div class="card">
            <div class="card-header">
                <h5>Data Instansi</h5>
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
                        <td>Email</td>
                        <td> : </td>
                        <td>{{$bank->email}}</td>
                    </tr>
                    <tr>
                        <td>Lokasi</td>
                        <td> : </td>
                    </tr>
                </table>
                <div id="map" style="height: 250px"></div>
            </div>
        </div>

        <br>

        <!-- DAFTAR JADWAL PEMBUANGAN -->
        @if(isset($pembuangan))
            <div class="card">
                <div class="card-header">
                    <h5>Daftar Jadwal Pembuangan</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Nama Pengguna</td>
                            <th>Role</td>
                        </tr>
                        @foreach($pembuangan as $p)
                            <tr>
                                <td>{{$p->nama}}</td>
                                <td>{{$p->role}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @endif

        <br>

        <!-- PENERIMAAN SAMPAH -->
        <div class="card">
            <div class="card-header">
                    <h5>Penerimaan Sampah</h5>
                </div>
            <div class="card-body">
                @if($totalSampah != NULL)
                <!-- BAR CHART -->
                <br>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

                    <script>
                        var xValues = ["Organik", "Anorganik"];
                        var yValues = [<?php echo $totalSampah -> total_organik ?>, <?php echo $totalSampah -> total_anorganik ?>, 0];
                        var barColors = ["green", "blue"];

                        new Chart("myChart", {
                            type: "bar",
                            data: {
                                labels: xValues,
                                datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                                }]
                            },
                            options: {
                                legend: {display: false},
                            }
                        });
                    </script>
                @endif
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
        L.marker([locations.latitude, locations.longitude], {icon : myIcon}).addTo(map).bindPopup(locations.nama).openPopup();
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
