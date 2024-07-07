@extends('layouts.main')
@section('title','Daftar Bank')
@section('content')

    <!-- NAVIGASI -->
    <div class="col-md-2 border">
        @include('layouts.petugas_navigasi')
    </div>


    <!-- BODY -->
    <div class="col-md-10">

@if($petugas->kapasitas_petugas!=null&&$petugas->longitude!=null&&$petugas->latitude!=null)


        <br>

        <!-- MAPS -->
        <div id="map" style="height: 250px"></div>

        <br><br>

        <!-- DAFTAR PENDAFTARAN BANK -->
        <div class="card">
            <div class="card-header">
                <h5>Daftar Pendaftaran Bank</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Nama Bank</th>
                        <th>Alamat</th>
                        <th>Nomor Telpon</th>
                        <th>Status</th>
                    </tr>
                    @foreach($pbs as $p)
                    <tr>
                        <td>{{$p->nama}}</td>
                        <td>{{$p->alamat}}</td>
                        <td>{{$p->telp}}</td>
                        <td>{{$p->status_daftar}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <br>

        <!-- DAFTAR BANK -->
        @foreach($bank as $b)
        <div class="card w-50">
            <div class="card-body">
                <table>
                    <tr>
                        <td>Nama Bank</td>
                        <td> : </td>
                        <td>{{$b->nama}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td> : </td>
                        <td>{{$b->alamat}}</td>
                    </tr>
                    <tr>
                        <td>Jarak</td>
                        <td> : </td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group mt-4">
                                <a href="/petugas_daftar_bank/insert/{{$b->id}}" type="submit" role="button" class="btn btn-primary" onclick="return confirm('Apakah anda yakin ingin mendaftar?')">Mendaftar</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <br>
        @endforeach

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
    // looping for create marker per location
        L.marker([locations.latitude, locations.longitude], {icon : myIcon}).addTo(map).bindPopup("You're Here!").openPopup();
        map.setView([locations.latitude, locations.longitude], 18);

        var locations_bank = <?php echo json_encode($bank); ?>;
        locations_bank.forEach(e => {
        L.marker([e.latitude,
        e.longitude], {icon : bankIcon}).addTo(map).bindPopup(e.nama);
        });
</script>
    @else
        <br>
        <h3>Anda Telah Melakukan Pengajuan!</h3>
    @endif

@endsection
