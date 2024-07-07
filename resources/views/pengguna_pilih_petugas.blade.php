@extends('layouts.main')
@section('title','Pilih Petugas')
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
            @if(session('alert')=='Data telah berhasil ditambahkan!')
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

        <!-- MAPS -->
        <div id="map" style="height: 250px"></div>

        <br><br>

        <!-- DAFTAR PETTUGAS -->
        @foreach($petugas as $p)
            <div class="card w-50">
                <div class="card-body">
                    <table>
                        <tr>
                            <td>Nama Petugas</td>
                            <td> : </td>
                            <td>{{$p->nama}}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td> : </td>
                            <td>{{$p->alamat}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Telpon</td>
                            <td> : </td>
                            <td>{{$p->telp}}</td>
                        </tr>
                        <tr>
                            <td>Iuran</td>
                            <td> : </td>
                            <td>{{$p->tarif_petugas}}</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group mt-4">
                                    <a href="/pengguna_pilih_petugas/insert/{{$p->id}}" type="submit" role="button" onclick="return confirm('Apakah anda yakin ingin berlangganan?')" class="btn btn-primary">Berlangganan</a>
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
        var locations = <?php echo json_encode($pengguna); ?>;
        console.log(locations);
        // looping for create marker per location
            L.marker([locations.latitude, locations.longitude], {icon : myIcon}).addTo(map).bindPopup(locations.nama).openPopup();
            map.setView([locations.latitude, locations.longitude], 18);

            var locations_petugas = <?php echo json_encode($petugas); ?>;
            locations_petugas.forEach(e => {
            L.marker([e.latitude,
            e.longitude], {icon : petugasIcon}).addTo(map).bindPopup(e.nama);
            });
    </script>

@endsection
