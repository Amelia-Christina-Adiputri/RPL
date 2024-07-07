@extends('layouts.main')
@section('title','Luaran')
@section('content')

<!-- NAVIGASI -->
<div class="col-md-2 border">
        @include('layouts.petugas_navigasi')
</div>

    <!-- BODY -->
    <div class="col-md-10">


        @if($beratSampah != NULL)
        <br>

        <!-- GRAFIK -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">></script>

        <div class="card">
            <div class="card-header">
                <h5>Grafik Pengambilan Sampah</h5>
            </div>
            <div class="card-body">
                <!-- BAR CHART -->
                <h5>Berat Sampah Organik dan Anorganik</h5>

                <br>
                    <canvas id="myBarChart" style="width:100%;max-width:600px"></canvas>
            </div>
        </div>

        <br>


        <div class="card">
            <div class="card-header">
                <h5>Grafik Langganan Sampah</h5>
            </div>
            <div class="card-body">
                <canvas id="myLineChart" style="width:100%;max-width:600px"></canvas>
            </div>
        </div>
    @endif
        <br>

        <div class="card">
            <div class="card-header">
                <h5>Lokasi Pengambilan</h5>
            </div>
            <div class="card-body">
                <div id="map" style="height: 250px"></div>
            </div>
        </div>

    </div>

    @if($beratSampah!=null)
        <script>
            var xValues = ["Organik", "Anorganik"];
            var yValues = [<?php echo $beratSampah -> berat_organik ?>, <?php echo $beratSampah -> berat_anorganik ?>, 0];
            var barColors = ["green", "blue"];

            var chart1 = new Chart("myBarChart", {
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

            const axValues = JSON.parse('<?= json_encode($xAxist); ?>');
            const ayValues = JSON.parse('<?= json_encode($yAxist); ?>');

            var chart1 = new Chart("myLineChart", {
            type: "line",
            data: {
                labels: axValues,
                datasets: [{
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(0,0,255,1.0)",
                borderColor: "rgba(0,0,255,0.1)",
                data: ayValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                yAxes: [{ticks: {min: 0}}],
                }
            }
            });
        </script>
    @endif
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
        // looping for create marker per location
            L.marker([locations.latitude, locations.longitude], {icon : myIcon}).addTo(map).bindPopup("You're Here!").openPopup();
            map.setView([locations.latitude, locations.longitude], 18);

            var locations_bank = <?php echo json_encode($lokasi); ?>;
            locations_bank.forEach(e => {
            L.marker([e.latitude,
            e.longitude], {icon : penggunaIcon}).addTo(map).bindPopup(e.nama);
            });
    </script>
@endsection

