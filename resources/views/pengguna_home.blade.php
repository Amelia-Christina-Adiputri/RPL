@extends('layouts.main')
@section('title','Home')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.pengguna_navigasi')
    </div>

    <!-- BODY -->
    <div class="col-md-10">

    <!-- ALERT -->
    <div>
            @if(session('alert'))
                @if(session('alert')=='Bukti pembayaran berhasil diupload!')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('alert')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            @endif
    </div>

    <br>

        <div id="map" style="height: 250px"></div>

        <!-- DATA LANGGANAN -->
        @if($psp_petugas!=null)

            <br>

            <div class="card">
                <div class="card-header">
                    <h5>Data Langganan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless w-auto">
                        <tr>
                            <td>Petugas</td>
                            <td> : </td>
                            <td>{{$psp_petugas->nama}}</td>
                        </tr>
                        <tr>
                            <td>Iuran</td>
                            <td> : </td>
                            <td>{{$psp_petugas->iuran}}</td>
                        </tr>
                        @if($psp_petugas->bukti_pembayaran != NULL)
                        <tr>
                            <td>Bukti Pembayaran</td>
                            <td> : </td>
                            <td>{{$psp_petugas->bukti_pembayaran}}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Status</td>
                            <td> : </td>
                            <td>{{$psp_petugas->status_terima}}</td>
                        </tr>
                        <tr>
                            <td>Masa Berlaku</td>
                            <td> : </td>
                            <td>{{$psp_petugas->tgl_berlaku_psp }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td> : </td>
                            <td>{{$psp_petugas->alamat}}</td>
                        </tr>
                        <tr>
                            <td>
                                @if($psp_petugas->status_terima == "Menunggu Pembayaran")
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insert_pembayaran">
                                    Bayar
                                    </button>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif

        <!-- DATA DAFTAR BANK -->
        @if($pbs!=null)

        <br>

        <div class="card">
            <div class="card-header">
                <h5>Data Daftar Bank</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless w-auto">
                    <tr>
                        <td>Bank</td>
                        <td> : </td>
                        <td>{{$pbs->nama}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td> : </td>
                        <td>{{$pbs->alamat}}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td> : </td>
                        <td>{{$pbs->status_daftar}}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif

        <br>
        @if($beratSampah != NULL)
            <!-- BAR CHART -->
            <div class="card">
                <div class="card-header">
                    <h5>Berat Sampah Organik dan Anorganik (KG)</h5>
                </div>
                <div class="card-body">

                    <br>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
                    <body>

                        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

                        <script>
                            var xValues = ["Organik", "Anorganik"];
                            var yValues = [<?php echo $beratSampah -> berat_organik ?>, <?php echo $beratSampah -> berat_anorganik ?>, 0];
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

                    </body>
                </div>
            </div>
        </div>
        @endif

        @if($psp_petugas!=null)
            <!-- Modal -->
            <div class="modal fade" id="insert_pembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Bukti Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/pengguna/bayar/{{$psp_petugas->id_trans_psp}}" method="post" enctype = "multipart/form-data" >
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Bukti Pembayaran</label>
                                <input type="file" class="form-control-file" name="file">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>

                    </div>
                </div>
            </div>
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
    var locations = <?php echo json_encode($pengguna); ?>;
    console.log(locations);
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

    var petugasLocations = <?php echo json_encode($psp_petugas); ?>;
    L.marker([petugasLocations.latitude, petugasLocations.longitude], {icon : petugasIcon}).addTo(map).bindPopup(petugasLocations.nama);

    var bankLocations = <?php echo json_encode($pbs); ?>;
    L.marker([bankLocations.latitude, bankLocations.longitude], {icon : bankIcon}).addTo(map).bindPopup(bankLocations.nama);
</script>
@endsection
